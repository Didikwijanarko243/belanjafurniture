<?php
namespace App\Providers;

use App\Models\Category;
use App\Models\Review;
use App\Services\CartService;
use App\Services\WishlistService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with([
                'cartCount'     => app(CartService::class)->getItemCount(),
                'wishlistCount' => app(WishlistService::class)->getCount(),
                'navCategories' => Category::active()
                    ->parentOnly()
                    ->orderBy('sort_order')
                    ->withCount('products')
                    ->get(),
            ]);
        });

        View::composer(['components.product-card', 'produk.show'], function ($view) {
            $view->with('wishlistProductIds', app(WishlistService::class)->getProductIds());
        });

        View::composer('admin.partials.sidebar', function ($view) {
            $view->with('pendingReviewCount', Review::where('status', 'pending')->count());
        });
    }
}
