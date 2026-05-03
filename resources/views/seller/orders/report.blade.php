@extends('layouts.app')
@section('title', 'Laporan Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Pesanan</h1>
            <p class="text-gray-500 mt-1">Data lengkap dengan JOIN tabel orders, order_items, services, users</p>
        </div>
        <a href="{{ route('seller.orders') }}" class="text-sm text-indigo-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
    </div>

    

    @if($orders->isEmpty())
    <div class="bg-white rounded-2xl p-16 text-center shadow-sm border border-gray-100">
        <i class="fas fa-chart-bar text-gray-400 text-4xl mb-4"></i>
        <p class="text-gray-400">Belum ada data pesanan</p>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="text-left py-3 px-4 font-semibold">Kode Order</th>
                        <th class="text-left py-3 px-4 font-semibold">Pembeli</th>
                        <th class="text-left py-3 px-4 font-semibold">Layanan</th>
                        <th class="text-left py-3 px-4 font-semibold">Kategori</th>
                        <th class="text-left py-3 px-4 font-semibold">Qty</th>
                        <th class="text-left py-3 px-4 font-semibold">Harga Satuan</th>
                        <th class="text-left py-3 px-4 font-semibold">Total</th>
                        <th class="text-left py-3 px-4 font-semibold">Status</th>
                        <th class="text-left py-3 px-4 font-semibold">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="py-3 px-4 font-mono text-xs font-bold text-indigo-700">{{ $order->order_code }}</td>
                        <td class="py-3 px-4">{{ $order->buyer_name }}</td>
                        <td class="py-3 px-4">{{ $order->service_name }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded text-xs">{{ str_replace('_',' ',ucwords($order->category,'_')) }}</span>
                        </td>
                        <td class="py-3 px-4 font-semibold">{{ $order->quantity }}</td>
                        <td class="py-3 px-4">Rp {{ number_format($order->unit_price, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded text-xs font-semibold
                                @if($order->status==='completed') bg-green-100 text-green-700
                                @elseif($order->status==='pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status==='processing') bg-purple-100 text-purple-700
                                @elseif($order->status==='cancelled') bg-red-100 text-red-700
                                @else bg-blue-100 text-blue-700 @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-400 text-xs">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100 flex justify-between items-center bg-gray-50">
            <p class="text-sm text-gray-500">Total <strong>{{ count($orders) }}</strong> transaksi</p>
            <p class="text-sm font-bold text-gray-800">Grand Total: Rp {{ number_format(collect($orders)->sum('total_price'), 0, ',', '.') }}</p>
        </div>
    </div>
    @endif
</div>
@endsection
