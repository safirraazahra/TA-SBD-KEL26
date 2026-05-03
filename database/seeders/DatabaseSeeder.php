<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = User::firstOrCreate(['email' => 'buyer@demo.com'], [
            'name'     => 'Budi Santoso',
            'password' => Hash::make('password'),
            'role'     => 'buyer',
            'phone'    => '081234567890',
            'address'  => 'Jl. Merdeka No. 10, Jakarta Pusat',
        ]);

        $seller = User::firstOrCreate(['email' => 'seller@demo.com'], [
            'name'              => 'Ani Rahayu',
            'password'          => Hash::make('password'),
            'role'              => 'seller',
            'phone'             => '082345678901',
            'address'           => 'Jl. Sudirman No. 25, Jakarta Selatan',
            'store_name'        => 'Print Center Jakarta',
            'store_description' => 'Jasa print & fotocopy profesional, harga terjangkau.',
        ]);

        $servicesData = [
            ['name' => 'Print Dokumen A4 Hitam Putih', 'description' => 'Cetak dokumen A4 hitam putih HVS 70gsm. Cocok untuk skripsi dan laporan.', 'category' => 'print_hitam_putih', 'price_per_unit' => 300, 'unit' => 'lembar', 'min_order' => 1, 'turnaround_days' => 1],
            ['name' => 'Print Foto / Berwarna A4',     'description' => 'Cetak foto atau dokumen berwarna A4 berkualitas tinggi.', 'category' => 'print_berwarna', 'price_per_unit' => 1500, 'unit' => 'lembar', 'min_order' => 1, 'turnaround_days' => 1],
            ['name' => 'Fotocopy Dokumen',             'description' => 'Fotocopy cepat dan terjangkau. Tersedia A4 dan F4.', 'category' => 'fotocopy', 'price_per_unit' => 200, 'unit' => 'lembar', 'min_order' => 5, 'turnaround_days' => 1],
            ['name' => 'Jilid Softcover',              'description' => 'Jilid laporan atau skripsi dengan cover plastik mika warna.', 'category' => 'jilid', 'price_per_unit' => 8000, 'unit' => 'buah', 'min_order' => 1, 'turnaround_days' => 1],
            ['name' => 'Laminating Glossy A4',         'description' => 'Laminating dokumen/foto finishing glossy. Tahan air.', 'category' => 'laminating', 'price_per_unit' => 3000, 'unit' => 'lembar', 'min_order' => 1, 'turnaround_days' => 1],
            ['name' => 'Scan Dokumen HD',              'description' => 'Scan dokumen resolusi tinggi 300 DPI. Output PDF/JPG.', 'category' => 'scan', 'price_per_unit' => 2000, 'unit' => 'lembar', 'min_order' => 1, 'turnaround_days' => 1],
        ];

        foreach ($servicesData as $svcData) {
            Service::firstOrCreate(
                ['seller_id' => $seller->id, 'name' => $svcData['name']],
                array_merge($svcData, ['seller_id' => $seller->id, 'is_active' => true])
            );
        }

        $service = Service::where('seller_id', $seller->id)->first();
        if ($service && Order::where('buyer_id', $buyer->id)->count() === 0) {
            $order = Order::create([
                'buyer_id'         => $buyer->id,
                'seller_id'        => $seller->id,
                'status'           => 'processing',
                'notes'            => 'Tolong print bolak-balik ya, makasih!',
                'delivery_address' => 'Jl. Merdeka No. 10, Jakarta Pusat',
                'delivery_method'  => 'pickup',
                'subtotal'         => 30000,
                'delivery_fee'     => 0,
                'total_price'      => 30000,
                'payment_method'   => 'transfer_bca',
                'payment_status'   => 'paid',
                'paid_at'          => now(),
            ]);
            OrderItem::create([
                'order_id'   => $order->id,
                'service_id' => $service->id,
                'quantity'   => 100,
                'unit_price' => 300,
                'subtotal'   => 30000,
                'notes'      => 'Print bolak-balik',
            ]);
            Payment::create([
                'order_id'    => $order->id,
                'method'      => 'transfer_bca',
                'amount'      => 30000,
                'status'      => 'verified',
                'verified_at' => now(),
            ]);
        }
    }
}
