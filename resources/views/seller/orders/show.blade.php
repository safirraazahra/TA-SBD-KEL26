@extends('layouts.app')
@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('seller.orders') }}" class="text-sm text-indigo-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
        <span class="px-4 py-1.5 rounded-full text-sm font-semibold
            @if($order->status==='completed') bg-green-100 text-green-700
            @elseif($order->status==='pending') bg-yellow-100 text-yellow-700
            @elseif($order->status==='processing') bg-purple-100 text-purple-700
            @elseif($order->status==='cancelled') bg-red-100 text-red-700
            @else bg-blue-100 text-blue-700 @endif">
            {{ $order->status_label }}
        </span>
    </div>

    <div class="space-y-4">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h1 class="text-xl font-bold text-gray-800 mb-4">{{ $order->order_code }}</h1>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-400 block">Pembeli</span>
                    <p class="font-semibold mt-0.5">{{ $order->buyer->name }}</p>
                    <p class="text-gray-400 text-xs">{{ $order->buyer->phone }}</p>
                </div>
                <div>
                    <span class="text-gray-400 block">Tanggal Pesan</span>
                    <p class="font-semibold mt-0.5">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <span class="text-gray-400 block">Pengiriman</span>
                    <p class="font-semibold mt-0.5">{{ $order->delivery_method === 'pickup' ? 'Ambil Sendiri' : 'Dikirim' }}</p>
                </div>
                <div>
                    <span class="text-gray-400 block">Alamat</span>
                    <p class="font-semibold mt-0.5 text-xs">{{ $order->delivery_address }}</p>
                </div>
                @if($order->notes)
                <div class="col-span-2">
                    <span class="text-gray-400 block">Catatan</span>
                    <p class="font-medium mt-0.5 text-indigo-700 bg-indigo-50 px-3 py-2 rounded-lg text-sm">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Items -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 mb-4">Item Pesanan</h2>
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-print text-indigo-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800 text-sm">{{ $item->service->name }}</p>
                        <p class="text-gray-400 text-xs">{{ $item->quantity }} × Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                    </div>
                    <p class="font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between font-bold">
                <span>Total</span>
                <span class="text-indigo-600 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 mb-4">Pembayaran</h2>
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm text-gray-400">Metode</p>
                    <p class="font-semibold">{{ $order->payment_method_label }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $order->payment_status==='paid'?'bg-green-100 text-green-700':'bg-yellow-100 text-yellow-700' }}">
                    {{ $order->payment_status === 'paid' ? '✓ Lunas' : 'Belum Dibayar' }}
                </span>
            </div>
            @if($order->payment_proof)
            <div>
                <p class="text-sm text-gray-400 mb-2">Bukti Pembayaran</p>
                <img src="{{ Storage::url($order->payment_proof) }}" alt="Bukti Bayar" class="h-48 rounded-xl object-cover border border-gray-200">
            </div>
            @endif
        </div>

        <!-- Update Status -->
        @if(!in_array($order->status, ['completed','cancelled']))
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 mb-4">Update Status Pesanan</h2>
            <form method="POST" action="{{ route('seller.orders.update-status', $order) }}" class="flex gap-3">
                @csrf @method('PATCH')
                <select name="status" class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 bg-white">
                    @if($order->status === 'pending')
                    <option value="confirmed">Konfirmasi Pesanan</option>
                    <option value="cancelled">Batalkan</option>
                    @elseif($order->status === 'confirmed')
                    <option value="processing">Mulai Proses</option>
                    <option value="cancelled">Batalkan</option>
                    @elseif($order->status === 'processing')
                    <option value="completed">Tandai Selesai</option>
                    @endif
                </select>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all">
                    Update
                </button>
            </form>
        </div>
        @endif

        <!-- Hard Delete -->
        <form method="POST" action="{{ route('seller.orders.force-delete', $order) }}" onsubmit="return confirm('Hapus permanen? Data tidak bisa dipulihkan!')">
            @csrf @method('DELETE')
            <button type="submit" class="w-full py-3 border-2 border-red-200 text-red-600 font-semibold rounded-xl hover:bg-red-50 transition-all">
                <i class="fas fa-trash-alt mr-2"></i>Hapus Permanen (Hard Delete)
            </button>
        </form>
    </div>
</div>
@endsection
