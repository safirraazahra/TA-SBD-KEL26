@extends('layouts.app')
@section('title', 'Kelola Layanan')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Layanan Saya</h1>
            <p class="text-gray-500 mt-1">Kelola semua layanan yang kamu tawarkan</p>
        </div>
        <a href="{{ route('seller.services.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
            <i class="fas fa-plus mr-2"></i>Tambah Layanan
        </a>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('seller.services') }}" class="flex gap-3">
            <div class="flex-1 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-search"></i></span>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari layanan..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <select name="category" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none bg-white">
                <option value="">Semua Kategori</option>
                <option value="print_hitam_putih" {{ $category==='print_hitam_putih'?'selected':'' }}>Print Hitam Putih</option>
                <option value="print_berwarna" {{ $category==='print_berwarna'?'selected':'' }}>Print Berwarna</option>
                <option value="fotocopy" {{ $category==='fotocopy'?'selected':'' }}>Fotocopy</option>
                <option value="jilid" {{ $category==='jilid'?'selected':'' }}>Jilid</option>
                <option value="laminating" {{ $category==='laminating'?'selected':'' }}>Laminating</option>
                <option value="scan" {{ $category==='scan'?'selected':'' }}>Scan</option>
                <option value="banner" {{ $category==='banner'?'selected':'' }}>Banner</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700">Cari</button>
        </form>
    </div>

    @if($services->isEmpty())
    <div class="bg-white rounded-2xl p-16 text-center shadow-sm border border-gray-100">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-box-open text-gray-400 text-3xl"></i>
        </div>
        <h3 class="font-semibold text-gray-600 mb-2">Belum ada layanan</h3>
        <a href="{{ route('seller.services.create') }}" class="inline-flex items-center gap-2 mt-3 px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition-all">
            <i class="fas fa-plus"></i>Tambah Layanan Pertama
        </a>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($services as $service)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-print text-indigo-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">{{ $service->name }}</p>
                                    <p class="text-gray-400 text-xs line-clamp-1">{{ Str::limit($service->description, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-medium">{{ $service->category_label }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <p class="font-semibold text-gray-800 text-sm">Rp {{ number_format($service->price_per_unit, 0, ',', '.') }}</p>
                            <p class="text-gray-400 text-xs">/ {{ $service->unit }}</p>
                        </td>
                        <td class="py-4 px-4">
                            <form method="POST" action="{{ route('seller.services.toggle', $service) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold {{ $service->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }} transition-all">
                                    <span class="w-2 h-2 rounded-full {{ $service->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                    {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('seller.services.edit', $service) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form method="POST" action="{{ route('seller.services.destroy', $service) }}" onsubmit="return confirm('Yakin hapus layanan ini? Ini tidak bisa dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                        <i class="fas fa-trash text-sm"></i>
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
    <div class="mt-4">{{ $services->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
