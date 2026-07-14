<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'consultation_id', 'session_id',
        'customer_name', 'customer_phone', 'customer_address',
        'status', 'total_price', 'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        do {
            $code = 'NAIMA-' . strtoupper(Str::random(8));
        } while (self::where('order_number', $code)->exists());

        return $code;
    }
}