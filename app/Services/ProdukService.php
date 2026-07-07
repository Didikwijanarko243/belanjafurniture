<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class ProdukService
{
    /**
     * Ambil daftar produk dengan filter, sorting, dan pencarian.
     * Semua parameter opsional lewat query string:
     * ?kategori=slug&min=100000&max=500000&material=jati&sort=termurah&q=meja
     */
    public function getListing(array $filters = []): LengthAwarePaginator
    {
        return Product::query()
            ->active()
            ->with(['category', 'images' => fn ($q) => $q->where('is_primary', true)])
            ->when($filters['kategori'] ?? null, function ($query, $slug) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $slug));
            })
            ->when($filters['min'] ?? null, function ($query, $min) {
                $query->where('price', '>=', $min);
            })
            ->when($filters['max'] ?? null, function ($query, $max) {
                $query->where('price', '<=', $max);
            })
            ->when($filters['material'] ?? null, function ($query, $material) {
                $query->where('material', $material);
            })
            ->when($filters['q'] ?? null, function ($query, $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->when($filters['sort'] ?? null, function ($query, $sort) {
                match ($sort) {
                    'termurah' => $query->orderBy('price', 'asc'),
                    'termahal' => $query->orderBy('price', 'desc'),
                    'terbaru' => $query->orderBy('created_at', 'desc'),
                    'terlaris' => $query->orderBy('views_count', 'desc'),
                    default => $query->orderBy('created_at', 'desc'),
                };
            }, function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->paginate(12)
            ->withQueryString();
    }

    /**
     * Ambil produk terkait untuk ditampilkan di halaman detail.
     */
    public function getRelated(Product $product, int $limit = 4)
    {
        return Product::query()
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['images' => fn ($q) => $q->where('is_primary', true)])
            ->limit($limit)
            ->get();
    }
}
