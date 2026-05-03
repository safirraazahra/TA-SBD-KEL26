@extends('layouts.app')
@section('title', 'Buat Pesanan')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('buyer.services.show', $service) }}" class="text-sm text-indigo-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Service Summary -->
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-6 text-white">
            <h1 class="text-xl font-bold mb-1">Buat Pesanan</h1>
            <p class="text-white/80 text-sm">{{ $service->name }} - {{ $service->seller->store_name ?? $service->seller->name }}</p>
        </div>

        <div class="p-6">
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                @foreach($errors->all() as $error)
                <p class="text-red-700 text-sm"><i class="fas fa-exclamation-triangle mr-1"></i>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('buyer.orders.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">

                <!-- Service Info Card -->
                <div class="flex gap-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                    <div class="w-16 h-16 bg-indigo-200 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-print text-indigo-600 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800">{{ $service->name }}</p>
                        <p class="text-gray-500 text-sm">{{ $service->category_label }}</p>
                        <p class="text-indigo-600 font-semibold">Rp {{ number_format($service->price_per_unit, 0, ',', '.') }} / {{ $service->unit }}</p>
                    </div>
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah ({{ $service->unit }}) <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" value="{{ old('quantity', $service->min_order) }}" min="{{ $service->min_order }}" id="qty"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <p class="text-xs text-gray-400 mt-1">Minimum order: {{ $service->min_order }} {{ $service->unit }}</p>
                </div>

                <!-- Delivery Method -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Metode Pengiriman <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="delivery-opt border-2 rounded-xl p-4 cursor-pointer transition-all {{ old('delivery_method','pickup') === 'pickup' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                            <input type="radio" name="delivery_method" value="pickup" class="hidden" {{ old('delivery_method','pickup') === 'pickup' ? 'checked' : '' }}>
                            <div class="text-center">
                                <i class="fas fa-store text-2xl mb-2 {{ old('delivery_method','pickup') === 'pickup' ? 'text-indigo-600' : 'text-gray-400' }}"></i>
                                <p class="font-semibold text-gray-800 text-sm">Ambil Sendiri</p>
                                <p class="text-gray-400 text-xs">Gratis</p>
                            </div>
                        </label>
                        <label class="delivery-opt border-2 rounded-xl p-4 cursor-pointer transition-all {{ old('delivery_method') === 'delivery' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                            <input type="radio" name="delivery_method" value="delivery" class="hidden" {{ old('delivery_method') === 'delivery' ? 'checked' : '' }}>
                            <div class="text-center">
                                <i class="fas fa-truck text-2xl mb-2 {{ old('delivery_method') === 'delivery' ? 'text-indigo-600' : 'text-gray-400' }}"></i>
                                <p class="font-semibold text-gray-800 text-sm">Dikirim</p>
                                <p class="text-gray-400 text-xs">+ Rp 15.000</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Pengiriman / Pickup <span class="text-red-500">*</span></label>
                    <textarea name="delivery_address" required rows="2"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 resize-none"
                        placeholder="Masukkan alamat lengkap...">{{ old('delivery_address', auth()->user()->address) }}</textarea>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan</label>
                    <textarea name="notes" rows="2"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 resize-none"
                        placeholder="Contoh: kertas A4, jilid softcover warna biru...">{{ old('notes') }}</textarea>
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach([
                            ['transfer_bca','BCA','fas fa-university','bg-blue-100 text-blue-700'],
                            ['transfer_mandiri','Mandiri','fas fa-university','bg-yellow-100 text-yellow-700'],
                            ['transfer_bri','BRI','fas fa-university','bg-blue-100 text-blue-800'],
                            ['gopay','GoPay','fas fa-wallet','bg-green-100 text-green-700'],
                            ['ovo','OVO','fas fa-wallet','bg-purple-100 text-purple-700'],
                            ['dana','DANA','fas fa-wallet','bg-blue-100 text-blue-600'],
                            ['cod','COD','fas fa-hand-holding-usd','bg-orange-100 text-orange-700'],
                        ] as [$val,$label,$icon,$color])
                        <label class="pay-opt border-2 rounded-xl p-3 cursor-pointer transition-all text-center {{ old('payment_method') === $val ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                            <input type="radio" name="payment_method" value="{{ $val }}" class="hidden" {{ old('payment_method') === $val ? 'checked' : '' }}>
                            <div class="w-10 h-10 {{ $color }} rounded-xl flex items-center justify-center mx-auto mb-2">
                                <i class="{{ $icon }} text-lg"></i>
                            </div>
                            <p class="font-semibold text-gray-800 text-xs">{{ $label }}</p>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-bold text-gray-800 mb-3">Ringkasan Pesanan</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Harga satuan</span>
                            <span class="font-medium">Rp {{ number_format($service->price_per_unit, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jumlah</span>
                            <span class="font-medium" id="qty-display">{{ $service->min_order }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Ongkos kirim</span>
                            <span class="font-medium" id="delivery-fee">Gratis</span>
                        </div>
                        <div class="border-t border-gray-200 pt-2 flex justify-between">
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="font-bold text-indigo-600 text-lg" id="total-price">Rp {{ number_format($service->price_per_unit * $service->min_order, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:opacity-90 transition-all shadow-lg shadow-indigo-200">
                    <i class="fas fa-check-circle mr-2"></i>Konfirmasi Pesanan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const pricePerUnit = {{ $service->price_per_unit }};
const qtyInput = document.getElementById('qty');
const qtyDisplay = document.getElementById('qty-display');
const deliveryFeeEl = document.getElementById('delivery-fee');
const totalPriceEl = document.getElementById('total-price');

let deliveryFee = 0;

function updateTotal() {
    const qty = parseInt(qtyInput.value) || 1;
    qtyDisplay.textContent = qty;
    const subtotal = pricePerUnit * qty;
    const total = subtotal + deliveryFee;
    totalPriceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
}

qtyInput.addEventListener('input', updateTotal);

document.querySelectorAll('.delivery-opt').forEach(opt => {
    opt.addEventListener('click', function() {
        document.querySelectorAll('.delivery-opt').forEach(o => {
            o.classList.remove('border-indigo-500', 'bg-indigo-50');
            o.classList.add('border-gray-200');
        });
        this.classList.add('border-indigo-500', 'bg-indigo-50');
        this.classList.remove('border-gray-200');
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
        deliveryFee = radio.value === 'delivery' ? 15000 : 0;
        deliveryFeeEl.textContent = deliveryFee > 0 ? 'Rp 15.000' : 'Gratis';
        updateTotal();
    });
});

document.querySelectorAll('.pay-opt').forEach(opt => {
    opt.addEventListener('click', function() {
        document.querySelectorAll('.pay-opt').forEach(o => {
            o.classList.remove('border-indigo-500', 'bg-indigo-50');
            o.classList.add('border-gray-200');
        });
        this.classList.add('border-indigo-500', 'bg-indigo-50');
        this.classList.remove('border-gray-200');
        this.querySelector('input').checked = true;
    });
});
</script>
@endsection
