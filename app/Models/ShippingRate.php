<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class ShippingRate extends Model
{
    protected $fillable = [
        'shipping_method_id', 'province', 'city',
        'price_per_kg', 'min_price',
        'estimated_days_min', 'estimated_days_max', 'is_active',
    ];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
        'min_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeForCity(Builder $query, string $city): Builder
    {
        return $query->where('city', $city);
    }

    // Ongkir = berat x tarif per kg, tapi tidak boleh di bawah tarif minimum
    public function calculateCost(float $weightInKg): float
    {
        $cost = $weightInKg * $this->price_per_kg;

        return max($cost, $this->min_price);
    }
}
