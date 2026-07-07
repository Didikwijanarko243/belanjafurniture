<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Product;

// ============ HOME ============
Route::get('/', function () {
    return view('pages.home', [
        'categories' => Category::active()->parentOnly()->orderBy('sort_order')->get(),
        'featuredProducts' => Product::active()->featured()->with('images')->take(8)->get(),
    ]);
})->name('home');

// ============ PRODUK ============
Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('produk.show');

// ============ KATEGORI ============
Route::get('/kategori/{category:slug}', [ProductController::class, 'byCategory'])->name('kategori.show');