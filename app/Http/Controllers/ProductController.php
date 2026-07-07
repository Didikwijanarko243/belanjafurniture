<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProdukService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(protected ProdukService $produkService)
    {
    }

    /**
     * Daftar semua produk, dengan filter lewat query string.
     * GET /produk
     */
    public function index(Request $request): View
    {
        $products = $this->produkService->getListing($request->only([
            'kategori', 'min', 'max', 'material', 'sort', 'q',
        ]));

        $categories = Category::active()->parentOnly()->orderBy('sort_order')->get();

        return view('produk.index', [
            'products' => $products,
            'categories' => $categories,
            'title' => 'Semua Produk - ' . config('app.name'),
            'metaDescription' => 'Jelajahi koleksi furniture kayu solid kami: sofa, meja, lemari, dan kursi berkualitas.',
        ]);
    }

    /**
     * Detail satu produk berdasarkan slug.
     * GET /produk/{product:slug}
     */
    public function show(Product $product): View
    {
        // Hanya hitung view untuk produk yang aktif, biar tidak dobel-log saat preview admin
        if ($product->is_active) {
            $product->increment('views_count');
        }

        $product->load(['images', 'variants' => fn ($q) => $q->active(), 'reviews.user']);

        $related = $this->produkService->getRelated($product);

        return view('produk.show', [
            'product' => $product,
            'related' => $related,
            'title' => $product->meta_title ?: $product->name . ' - ' . config('app.name'),
            'metaDescription' => $product->meta_description ?: $product->short_description,
        ]);
    }

    /**
     * Daftar produk berdasarkan kategori.
     * GET /kategori/{category:slug}
     */
    public function byCategory(Request $request, Category $category): View
    {
        $filters = array_merge(
            $request->only(['min', 'max', 'material', 'sort', 'q']),
            ['kategori' => $category->slug]
        );

        $products = $this->produkService->getListing($filters);

        $categories = Category::active()->parentOnly()->orderBy('sort_order')->get();

        return view('produk.index', [
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $category,
            'title' => $category->meta_title ?: $category->name . ' - ' . config('app.name'),
            'metaDescription' => $category->meta_description ?: $category->description,
        ]);
    }
}
