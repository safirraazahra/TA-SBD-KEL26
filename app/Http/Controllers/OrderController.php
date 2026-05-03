<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Buyer: list orders
    public function buyerIndex(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('q');

        $orders = Order::where('buyer_id', Auth::id())
            ->with(['seller', 'items.service'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($search, fn($q) => $q->where('order_code', 'like', "%$search%"))
            ->latest()
            ->paginate(10);

        return view('buyer.orders.index', compact('orders', 'status', 'search'));
    }

    // Buyer: show order detail
    public function buyerShow(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) abort(403);
        $order->load(['seller', 'items.service', 'payment']);
        return view('buyer.orders.show', compact('order'));
    }

    // Buyer: create order form
    public function create(Service $service)
    {
        if (!$service->is_active) abort(404);
        return view('buyer.orders.create', compact('service'));
    }

    // Buyer: store order
    public function store(Request $request)
    {
        $request->validate([
            'service_id'      => ['required', 'exists:services,id'],
            'quantity'        => ['required', 'integer', 'min:1'],
            'notes'           => ['nullable', 'string'],
            'delivery_address'=> ['required', 'string'],
            'delivery_method' => ['required', 'in:pickup,delivery'],
            'payment_method'  => ['required', 'in:transfer_bca,transfer_mandiri,transfer_bri,gopay,ovo,dana,cod'],
        ]);

        $service = Service::findOrFail($request->service_id);
        if (!$service->is_active) abort(422, 'Layanan tidak tersedia.');

        DB::transaction(function () use ($request, $service) {
            $subtotal     = $service->price_per_unit * $request->quantity;
            $deliveryFee  = $request->delivery_method === 'delivery' ? 15000 : 0;
            $totalPrice   = $subtotal + $deliveryFee;

            $order = Order::create([
                'buyer_id'         => Auth::id(),
                'seller_id'        => $service->seller_id,
                'status'           => 'pending',
                'notes'            => $request->notes,
                'delivery_address' => $request->delivery_address,
                'delivery_method'  => $request->delivery_method,
                'subtotal'         => $subtotal,
                'delivery_fee'     => $deliveryFee,
                'total_price'      => $totalPrice,
                'payment_method'   => $request->payment_method,
                'payment_status'   => 'pending',
            ]);

            OrderItem::create([
                'order_id'   => $order->id,
                'service_id' => $service->id,
                'quantity'   => $request->quantity,
                'unit_price' => $service->price_per_unit,
                'subtotal'   => $subtotal,
                'notes'      => $request->notes,
            ]);

            Payment::create([
                'order_id' => $order->id,
                'method'   => $request->payment_method,
                'amount'   => $totalPrice,
                'status'   => 'pending',
            ]);
        });

        return redirect()->route('buyer.orders')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    // Buyer: upload payment proof
    public function uploadProof(Request $request, Order $order)
    {
        if ($order->buyer_id !== Auth::id()) abort(403);

        $request->validate([
            'payment_proof' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $order->update([
            'payment_proof'  => $path,
            'payment_status' => 'paid',
            'paid_at'        => now(),
        ]);

        $order->payment?->update(['proof_path' => $path, 'status' => 'verified']);

        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    // Buyer: soft delete (cancel)
    public function cancel(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) abort(403);
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }
        $order->update(['status' => 'cancelled']);
        $order->delete(); // soft delete
        return redirect()->route('buyer.orders')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // Seller: list orders
    public function sellerIndex(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('q');

        // JOIN query: orders + order_items + services + users (buyer)
        $orders = Order::where('seller_id', Auth::id())
            ->with(['buyer', 'items.service', 'payment'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($search, fn($q) => $q->where('order_code', 'like', "%$search%")
                                        ->orWhereHas('buyer', fn($q2) => $q2->where('name', 'like', "%$search%")))
            ->latest()
            ->paginate(10);

        return view('seller.orders.index', compact('orders', 'status', 'search'));
    }

    // Seller: show order
    public function sellerShow(Order $order)
    {
        if ($order->seller_id !== Auth::id()) abort(403);
        $order->load(['buyer', 'items.service', 'payment']);
        return view('seller.orders.show', compact('order'));
    }

    // Seller: update order status
    public function updateStatus(Request $request, Order $order)
    {
        if ($order->seller_id !== Auth::id()) abort(403);

        $request->validate([
            'status' => ['required', 'in:confirmed,processing,completed,cancelled'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    // Seller: hard delete order
    public function forceDelete(Order $order)
    {
        if ($order->seller_id !== Auth::id()) abort(403);
        $order->forceDelete();
        return redirect()->route('seller.orders')->with('success', 'Pesanan berhasil dihapus permanen.');
    }

    // Seller: join query report
    public function report()
    {
        $orders = DB::table('orders')
            ->join('users as buyers', 'orders.buyer_id', '=', 'buyers.id')
            ->join('users as sellers', 'orders.seller_id', '=', 'sellers.id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('services', 'order_items.service_id', '=', 'services.id')
            ->select(
                'orders.order_code',
                'orders.status',
                'orders.total_price',
                'orders.created_at',
                'buyers.name as buyer_name',
                'sellers.name as seller_name',
                'services.name as service_name',
                'order_items.quantity',
                'order_items.unit_price',
                'services.category'
            )
            ->where('orders.seller_id', Auth::id())
            ->whereNull('orders.deleted_at')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return view('seller.orders.report', compact('orders'));
    }
}
