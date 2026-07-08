<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
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

// ============ KERANJANG ============
Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/tambah', [CartController::class, 'store'])->name('keranjang.store');
Route::patch('/keranjang/{cartItem}', [CartController::class, 'update'])->name('keranjang.update');
Route::delete('/keranjang/{cartItem}', [CartController::class, 'destroy'])->name('keranjang.destroy');

// ============ WISHLIST ============
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
