@extends('layouts.app')
@section('title', $service->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('buyer.services') }}" class="text-sm text-indigo-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i>Kembali ke Layanan</a>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <!-- Image -->
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl overflow-hidden h-72 flex items-center justify-center">
            @if($service->image)
            <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
            @else
            <i class="fas fa-print text-7xl text-white/60"></i>
            @endif
        </div>

        <!-- Info -->
        <div>
            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">{{ $service->category_label }}</span>
            <h1 class="text-2xl font-bold text-gray-800 mt-3 mb-2">{{ $service->name }}</h1>
            <p class="text-gray-500 text-sm mb-4">{{ $service->description }}</p>

            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-store text-indigo-600 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ $service->seller->store_name ?? $service->seller->name }}</p>
                    <p class="text-xs text-gray-400">{{ $service->seller->address }}</p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-4 mb-6 space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Harga per {{ $service->unit }}</span>
                    <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($service->price_per_unit, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Minimum Order</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $service->min_order }} {{ $service->unit }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Estimasi Pengerjaan</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $service->turnaround_days }} hari kerja</span>
                </div>
            </div>

            <a href="{{ route('buyer.orders.create', $service) }}"
                class="w-full block text-center py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:opacity-90 transition-all shadow-lg shadow-indigo-200">
                <i class="fas fa-shopping-cart mr-2"></i>Pesan Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
