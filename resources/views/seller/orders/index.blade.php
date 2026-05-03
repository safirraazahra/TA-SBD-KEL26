@extends('layouts.app')
@section('title', 'Kelola Pesanan')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pesanan Masuk</h1>
            <p class="text-gray-500 mt-1">Kelola semua pesanan dari pelanggan</p>
        </div>
        <a href="{{ route('seller.orders.report') }}" class="px-4 py-2.5 border border-indigo-200 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-50 transition-all">
            <i class="fas fa-file-alt mr-1"></i>Laporan
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('seller.orders') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-search"></i></span>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari kode pesanan atau nama pembeli..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <select name="status" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none bg-white">
                <option value="">Semua Status</option>
                <option value="pending" {{ $status==='pending'?'selected':'' }}>Menunggu Konfirmasi</option>
                <option value="confirmed" {{ $status==='confirmed'?'selected':'' }}>Dikonfirmasi</option>
                <option value="processing" {{ $status==='processing'?'selected':'' }}>Diproses</option>
                <option value="completed" {{ $status==='completed'?'selected':'' }}>Selesai</option>
                <option value="cancelled" {{ $status==='cancelled'?'selected':'' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700">Filter</button>
        </form>
    </div>

    @if($orders->isEmpty())
    <div class="bg-white rounded-2xl p-16 text-center shadow-sm border border-gray-100">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-inbox text-gray-400 text-3xl"></i>
        </div>
        <h3 class="font-semibold text-gray-600 mb-2">Belum ada pesanan masuk</h3>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Pesanan</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Pembeli</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Total</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Pembayaran</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="py-4 px-4">
                            <p class="font-bold text-gray-800 text-sm">{{ $order->order_code }}</p>
                            <p class="text-gray-400 text-xs">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs">
                                    {{ strtoupper(substr($order->buyer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 text-sm">{{ $order->buyer->name }}</p>
                                    <p class="text-gray-400 text-xs">{{ $order->buyer->phone }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <p class="font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            <p class="text-gray-400 text-xs">{{ $order->items->count() }} item</p>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->payment_status==='paid'?'bg-green-100 text-green-700':'bg-yellow-100 text-yellow-700' }}">
                                {{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                @if($order->status==='completed') bg-green-100 text-green-700
                                @elseif($order->status==='pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status==='processing') bg-purple-100 text-purple-700
                                @elseif($order->status==='cancelled') bg-red-100 text-red-700
                                @else bg-blue-100 text-blue-700 @endif">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('seller.orders.show', $order) }}" class="px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-semibold hover:bg-indigo-200 transition-all">
                                    Detail
                                </a>
                                <form method="POST" action="{{ route('seller.orders.force-delete', $order) }}" onsubmit="return confirm('Hapus permanen pesanan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus Permanen">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $orders->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
