@extends('layouts.app')
@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('buyer.orders') }}" class="text-sm text-indigo-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
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
        <!-- Order Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $order->order_code }}</h1>
                    <p class="text-gray-400 text-sm">Dipesan {{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-400">Toko</span><p class="font-semibold mt-0.5">{{ $order->seller->store_name ?? $order->seller->name }}</p></div>
                <div><span class="text-gray-400">Pengiriman</span><p class="font-semibold mt-0.5">{{ $order->delivery_method === 'pickup' ? 'Ambil Sendiri' : 'Dikirim' }}</p></div>
                <div class="col-span-2"><span class="text-gray-400">Alamat</span><p class="font-semibold mt-0.5">{{ $order->delivery_address }}</p></div>
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
                        @if($item->notes)<p class="text-gray-500 text-xs mt-1"><i class="fas fa-sticky-note mr-1"></i>{{ $item->notes }}</p>@endif
                    </div>
                    <p class="font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>

            <div class="border-t border-gray-100 mt-4 pt-4 space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-400">Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-400">Ongkos Kirim</span><span>{{ $order->delivery_fee > 0 ? 'Rp '.number_format($order->delivery_fee,0,',','.') : 'Gratis' }}</span></div>
                <div class="flex justify-between font-bold text-base pt-1 border-t border-gray-100">
                    <span>Total</span><span class="text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 mb-4">Pembayaran</h2>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-400">Metode</p>
                    <p class="font-semibold">{{ $order->payment_method_label }}</p>
                </div>
                <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $order->payment_status==='paid'?'bg-green-100 text-green-700':'bg-yellow-100 text-yellow-700' }}">
                    {{ $order->payment_status === 'paid' ? '✓ Lunas' : 'Belum Dibayar' }}
                </span>
            </div>

            @if($order->payment_proof)
            <div class="mb-4">
                <p class="text-sm text-gray-400 mb-2">Bukti Pembayaran</p>
                <img src="{{ Storage::url($order->payment_proof) }}" alt="Bukti Bayar" class="h-40 rounded-xl object-cover border border-gray-200">
            </div>
            @endif

            @if($order->payment_status !== 'paid' && !in_array($order->status, ['cancelled','completed']))
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-4">
                <p class="text-yellow-800 text-sm font-medium mb-1"><i class="fas fa-info-circle mr-1"></i>Informasi Transfer</p>
                @if(str_contains($order->payment_method, 'transfer'))
                <p class="text-yellow-700 text-sm">Silakan transfer ke rekening berikut:</p>
                <div class="mt-2 font-mono text-sm bg-white rounded-lg p-3 border border-yellow-200">
                    @if($order->payment_method === 'transfer_bca')
                    BCA - 1234567890 a.n PrintHub Official
                    @elseif($order->payment_method === 'transfer_mandiri')
                    Mandiri - 0987654321 a.n PrintHub Official
                    @else
                    BRI - 1122334455 a.n PrintHub Official
                    @endif
                </div>
                @elseif(in_array($order->payment_method, ['gopay','ovo','dana']))
                <p class="text-yellow-700 text-sm">Transfer ke {{ strtoupper($order->payment_method) }}: <strong>08123456789</strong></p>
                @endif
                <p class="text-yellow-700 text-sm mt-2">Total: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></p>
            </div>

            <form method="POST" action="{{ route('buyer.orders.upload-proof', $order) }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <label class="block text-sm font-semibold text-gray-700">Upload Bukti Pembayaran</label>
                <input type="file" name="payment_proof" accept="image/*" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all">
                    <i class="fas fa-upload mr-2"></i>Upload Bukti Pembayaran
                </button>
            </form>
            @endif
        </div>

        <!-- Cancel Button -->
        @if(in_array($order->status, ['pending','confirmed']))
        <form method="POST" action="{{ route('buyer.orders.cancel', $order) }}" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
            @csrf
            <button type="submit" class="w-full py-3 border-2 border-red-200 text-red-600 font-semibold rounded-xl hover:bg-red-50 transition-all">
                <i class="fas fa-times-circle mr-2"></i>Batalkan Pesanan
            </button>
        </form>
        @endif
    </div>
</div>
@endsection
