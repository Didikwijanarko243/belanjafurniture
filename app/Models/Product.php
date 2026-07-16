<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'description', 'short_description',
        'price', 'sale_price', 'stock',
        'weight', 'length', 'width', 'height', 'material', 'finishing',
        'is_custom_order', 'production_days',
        'is_featured', 'is_active', 'views_count',
        'meta_title', 'meta_description', 'canonical_url',
        'og_title', 'og_description', 'og_image',
    ];

    protected $casts = [
        'price'           => 'decimal:2',
        'sale_price'      => 'decimal:2',
        'weight'          => 'decimal:2',
        'length'          => 'decimal:2',
        'width'           => 'decimal:2',
        'height'          => 'decimal:2',
        'is_custom_order' => 'boolean',
        'is_featured'     => 'boolean',
        'is_active'       => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->images()->where('is_primary', true);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

// app/Models/Product.php — tambahkan method-method ini

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved')->latest();
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewCountAttribute(): int
    {
        return $this->approvedReviews()->count();
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    // Harga final setelah diskon, dipakai di tampilan produk
    public function getFinalPriceAttribute(): float
    {
        return $this->sale_price ?? $this->price;
    }

    // Dimensi gabungan, memudahkan tampilan "120 x 60 x 80 cm" di halaman detail
    public function getDimensionAttribute(): ?string
    {
        if (! $this->length || ! $this->width || ! $this->height) {
            return null;
        }

        return "{$this->length} x {$this->width} x {$this->height} cm";
    }

    

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
