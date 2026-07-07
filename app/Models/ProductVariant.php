<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'sku', 'color', 'size', 'additional_price', 'stock', 'image', 'is_active',
    ];

    protected $casts = [
        'additional_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // Harga akhir varian = harga produk induk + tambahan
    public function getFinalPriceAttribute(): float
    {
        return $this->product->final_price + $this->additional_price;
    }
}
