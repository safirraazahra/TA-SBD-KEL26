@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pesanan Saya</h1>
            <p class="text-gray-500 mt-1">Pantau semua pesananmu di sini</p>
        </div>
        <a href="{{ route('buyer.services') }}" class="px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-all">
            <i class="fas fa-plus mr-1"></i>Pesan Baru
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('buyer.orders') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-search"></i></span>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari kode pesanan..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <select name="status" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 bg-white">
                <option value="">Semua Status</option>
                <option value="pending" {{ $status === 'pending' ? 'selected':'' }}>Menunggu Konfirmasi</option>
                <option value="confirmed" {{ $status === 'confirmed' ? 'selected':'' }}>Dikonfirmasi</option>
                <option value="processing" {{ $status === 'processing' ? 'selected':'' }}>Diproses</option>
                <option value="completed" {{ $status === 'completed' ? 'selected':'' }}>Selesai</option>
                <option value="cancelled" {{ $status === 'cancelled' ? 'selected':'' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-all">Filter</button>
            @if($search || $status)
            <a href="{{ route('buyer.orders') }}" class="px-5 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-semibold hover:bg-gray-200 transition-all">Reset</a>
            @endif
        </form>
    </div>

    @if($orders->isEmpty())
    <div class="bg-white rounded-2xl p-16 text-center shadow-sm border border-gray-100">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-box-open text-gray-400 text-3xl"></i>
        </div>
        <h3 class="font-semibold text-gray-600 mb-2">Belum ada pesanan</h3>
        <a href="{{ route('buyer.services') }}" class="inline-flex items-center gap-2 mt-3 px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition-all">
            <i class="fas fa-store"></i>Mulai Pesan
        </a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all">
            <div class="flex items-center justify-between p-4 border-b border-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-receipt text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm">{{ $order->order_code }}</p>
                        <p class="text-xs text-gray-400">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <span class="px-3 py-1.5 rounded-full text-xs font-semibold
                    @if($order->status==='completed') bg-green-100 text-green-700
                    @elseif($order->status==='pending') bg-yellow-100 text-yellow-700
                    @elseif($order->status==='processing') bg-purple-100 text-purple-700
                    @elseif($order->status==='cancelled') bg-red-100 text-red-700
                    @else bg-blue-100 text-blue-700 @endif">
                    {{ $order->status_label }}
                </span>
            </div>
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Toko: <span class="font-medium text-gray-800">{{ $order->seller->store_name ?? $order->seller->name }}</span></p>
                        <p class="text-sm text-gray-500 mt-1">{{ $order->items->count() }} item • {{ ucfirst($order->delivery_method) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400">Total</p>
                        <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p class="text-xs mt-1 {{ $order->payment_status==='paid'?'text-green-600':'text-yellow-600' }} font-medium capitalize">
                            {{ $order->payment_status === 'paid' ? '✓ Dibayar' : 'Belum dibayar' }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-3 pt-3 border-t border-gray-50">
                    <a href="{{ route('buyer.orders.show', $order) }}" class="flex-1 text-center py-2 border border-indigo-200 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-50 transition-all">
                        Detail Pesanan
                    </a>
                    @if(in_array($order->status, ['pending','confirmed']) && $order->payment_status !== 'paid')
                    <a href="{{ route('buyer.orders.show', $order) }}" class="flex-1 text-center py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-all">
                        Bayar Sekarang
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $orders->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
