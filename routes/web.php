<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ConsultationController as AdminConsultationController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// ============ HOME ============
Route::get('/', function () {
    return view('pages.home', [
        'categories'       => Category::active()->parentOnly()->orderBy('sort_order')->get(),
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

//============= TENTANG ===============
Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang');

// ============ KONTAK =================
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');

Route::get('/cara-belanja', [PageController::class, 'caraBelanja'])->name('cara-belanja');
Route::post('/cart/whatsapp', [CartController::class, 'sendToWhatsapp'])->name('cart.whatsapp');

// Cart → WhatsApp (pastikan ini sudah ada, sesuaikan nama controller cart kamu)
Route::post('/cart/whatsapp', [CartController::class, 'sendToWhatsapp'])->name('cart.whatsapp');

// Tracking order (publik)
Route::get('/lacak-pesanan', [OrderTrackingController::class, 'form'])->name('order.track.form');
Route::post('/lacak-pesanan', [OrderTrackingController::class, 'lookup'])->name('order.track');

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/konsultasi', [AdminConsultationController::class, 'index'])->name('consultations.index');
        Route::get('/konsultasi/{consultation}', [AdminConsultationController::class, 'show'])->name('consultations.show');
        Route::patch('/konsultasi/{consultation}', [AdminConsultationController::class, 'updateStatus'])->name('consultations.update');
        Route::get('/konsultasi/{consultation}/jadikan-order', [AdminConsultationController::class, 'showConvertForm'])->name('consultations.convert.form');
        Route::post('/konsultasi/{consultation}/jadikan-order', [AdminConsultationController::class, 'convertToOrder'])->name('consultations.convert');

        Route::get('/order', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/order/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/order/{order}', [AdminOrderController::class, 'updateStatus'])->name('orders.update');

        Route::get('/kategori', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::get('/kategori/tambah', [AdminCategoryController::class, 'create'])->name('categories.create');
        Route::post('/kategori', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('/kategori/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/kategori/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/kategori/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/produk', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/produk/tambah', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/produk', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/produk/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/produk/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/produk/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    });
});
