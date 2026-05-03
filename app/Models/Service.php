<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id', 'name', 'description', 'category', 'price_per_unit',
        'unit', 'min_order', 'turnaround_days', 'image', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'price_per_unit' => 'decimal:2',
        ];
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        $labels = [
            'print_hitam_putih' => 'Print Hitam Putih',
            'print_berwarna'    => 'Print Berwarna',
            'fotocopy'          => 'Fotocopy',
            'jilid'             => 'Jilid',
            'laminating'        => 'Laminating',
            'scan'              => 'Scan',
            'banner'            => 'Banner',
            'lainnya'           => 'Lainnya',
        ];
        return $labels[$this->category] ?? $this->category;
    }
}
