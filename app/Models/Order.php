<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_code', 'buyer_id', 'seller_id', 'status', 'notes',
        'delivery_address', 'delivery_method', 'subtotal', 'delivery_fee',
        'total_price', 'payment_method', 'payment_status', 'payment_proof', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'    => 'decimal:2',
            'delivery_fee'=> 'decimal:2',
            'total_price' => 'decimal:2',
            'paid_at'     => 'datetime',
        ];
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'pending'    => 'Menunggu Konfirmasi',
            'confirmed'  => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        $colors = [
            'pending'    => 'yellow',
            'confirmed'  => 'blue',
            'processing' => 'purple',
            'completed'  => 'green',
            'cancelled'  => 'red',
        ];
        return $colors[$this->status] ?? 'gray';
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        $labels = [
            'transfer_bca'     => 'Transfer BCA',
            'transfer_mandiri' => 'Transfer Mandiri',
            'transfer_bri'     => 'Transfer BRI',
            'gopay'            => 'GoPay',
            'ovo'              => 'OVO',
            'dana'             => 'DANA',
            'cod'              => 'Bayar di Tempat (COD)',
        ];
        return $labels[$this->payment_method] ?? $this->payment_method;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            if (empty($order->order_code)) {
                $order->order_code = 'PH-' . strtoupper(uniqid());
            }
        });
    }
}
