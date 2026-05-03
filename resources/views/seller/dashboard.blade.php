@extends('layouts.app')
@section('title', 'Dashboard Penjual')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Penjual</h1>
        <p class="text-gray-500">{{ auth()->user()->store_name ?? auth()->user()->name }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="col-span-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white">
            <p class="text-white/80 text-sm mb-1">Total Pendapatan</p>
            <p class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-white/60 text-xs mt-1">Dari pesanan selesai</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-box text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">{{ $totalServices }}</p>
                <p class="text-gray-400 text-xs">Total Layanan</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-green-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">{{ $activeServices }}</p>
                <p class="text-gray-400 text-xs">Layanan Aktif</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-clock text-yellow-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">{{ $pendingOrders }}</p>
                <p class="text-gray-400 text-xs">Pesanan Baru</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-shopping-bag text-purple-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
                <p class="text-gray-400 text-xs">Total Pesanan</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid md:grid-cols-3 gap-4 mb-8">
        <a href="{{ route('seller.services.create') }}" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:border-indigo-300 hover:shadow-md transition-all flex items-center gap-4 group">
            <div class="w-12 h-12 bg-indigo-100 group-hover:bg-indigo-500 rounded-xl flex items-center justify-center transition-all">
                <i class="fas fa-plus text-indigo-600 group-hover:text-white"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800">Tambah Layanan</p>
                <p class="text-gray-400 text-xs">Buat layanan baru</p>
            </div>
        </a>
        <a href="{{ route('seller.orders') }}" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:border-indigo-300 hover:shadow-md transition-all flex items-center gap-4 group">
            <div class="w-12 h-12 bg-yellow-100 group-hover:bg-yellow-500 rounded-xl flex items-center justify-center transition-all relative">
                <i class="fas fa-clipboard-list text-yellow-600 group-hover:text-white"></i>
                @if($pendingOrders > 0)
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center">{{ $pendingOrders }}</span>
                @endif
            </div>
            <div>
                <p class="font-semibold text-gray-800">Kelola Pesanan</p>
                <p class="text-gray-400 text-xs">{{ $pendingOrders }} pesanan baru</p>
            </div>
        </a>
        <a href="{{ route('seller.orders.report') }}" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:border-indigo-300 hover:shadow-md transition-all flex items-center gap-4 group">
            <div class="w-12 h-12 bg-green-100 group-hover:bg-green-500 rounded-xl flex items-center justify-center transition-all">
                <i class="fas fa-chart-bar text-green-600 group-hover:text-white"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800">Laporan Pesanan</p>
                <p class="text-gray-400 text-xs">Data JOIN lengkap</p>
            </div>
        </a>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h2>
            <a href="{{ route('seller.orders') }}" class="text-sm text-indigo-600 font-medium hover:underline">Lihat semua</a>
        </div>
        @if($recentOrders->isEmpty())
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-400 text-sm">Belum ada pesanan masuk</p>
        </div>
        @else
        <div class="divide-y divide-gray-50">
            @foreach($recentOrders as $order)
            <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-receipt text-indigo-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $order->order_code }}</p>
                        <p class="text-gray-400 text-xs">{{ $order->buyer->name }} • {{ $order->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                        @if($order->status==='completed') bg-green-100 text-green-700
                        @elseif($order->status==='pending') bg-yellow-100 text-yellow-700
                        @elseif($order->status==='processing') bg-purple-100 text-purple-700
                        @elseif($order->status==='cancelled') bg-red-100 text-red-700
                        @else bg-blue-100 text-blue-700 @endif">
                        {{ $order->status_label }}
                    </span>
                    <p class="text-sm font-bold text-gray-800 hidden sm:block">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    <a href="{{ route('seller.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-chevron-right text-sm"></i></a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
