@extends('layouts.app')
@section('title', 'Edit Layanan')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('seller.services') }}" class="text-sm text-indigo-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-white">
            <h1 class="text-xl font-bold">Edit Layanan</h1>
            <p class="text-white/80 text-sm mt-1">{{ $service->name }}</p>
        </div>

        <div class="p-6">
            @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
                @foreach($errors->all() as $error)
                <p class="text-red-700 text-sm"><i class="fas fa-exclamation-triangle mr-1"></i>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('seller.services.update', $service) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Layanan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $service->name) }}" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 bg-white">
                        @foreach(['print_hitam_putih'=>'Print Hitam Putih','print_berwarna'=>'Print Berwarna','fotocopy'=>'Fotocopy','jilid'=>'Jilid','laminating'=>'Laminating','scan'=>'Scan','banner'=>'Banner','lainnya'=>'Lainnya'] as $val=>$label)
                        <option value="{{ $val }}" {{ old('category', $service->category)===$val?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="description" required rows="3"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 resize-none">{{ old('description', $service->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga per Satuan (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price_per_unit" value="{{ old('price_per_unit', $service->price_per_unit) }}" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Satuan <span class="text-red-500">*</span></label>
                        <input type="text" name="unit" value="{{ old('unit', $service->unit) }}" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Minimum Order</label>
                        <input type="number" name="min_order" value="{{ old('min_order', $service->min_order) }}" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Estimasi (hari)</label>
                        <input type="number" name="turnaround_days" value="{{ old('turnaround_days', $service->turnaround_days) }}" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Layanan</label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded accent-indigo-600">
                        <span class="text-sm text-gray-700">Layanan aktif (terlihat oleh pembeli)</span>
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ganti Foto (opsional)</label>
                    @if($service->image)
                    <div class="mb-3">
                        <img src="{{ Storage::url($service->image) }}" alt="Foto saat ini" class="h-24 rounded-xl object-cover border border-gray-200">
                        <p class="text-xs text-gray-400 mt-1">Foto saat ini</p>
                    </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:opacity-90 transition-all">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('seller.services') }}" class="px-6 py-3 border border-gray-200 text-gray-600 rounded-xl font-semibold hover:bg-gray-50 transition-all">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
