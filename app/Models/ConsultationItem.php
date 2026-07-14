<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationItem extends Model
{
    protected $fillable = [
        'consultation_id', 'product_id', 'product_variant_id',
        'product_name', 'variant_name', 'quantity', 'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }
}