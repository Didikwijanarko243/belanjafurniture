<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\WishlistService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function __construct(protected WishlistService $wishlistService)
    {
    }

    /**
     * GET /wishlist
     */
    public function index(): View
    {
        $productIds = $this->wishlistService->getProductIds();

        // dd($productIds);
        $products = Product::query()
            ->whereIn('id', $productIds)
            ->with(['images' => fn ($q) => $q->where('is_primary', true), 'category'])
            ->get();

        return view('pages.wishlist.index', [
            'products' => $products,
            'title' => 'Wishlist - ' . config('app.name'),
        ]);
    }

    /**
     * POST /wishlist/toggle
     * Dipanggil via fetch dari tombol hati (ikon wishlist).
     */
    public function toggle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $inWishlist = $this->wishlistService->toggle($validated['product_id']);

        return response()->json([
            'success' => true,
            'inWishlist' => $inWishlist,
            'wishlistCount' => $this->wishlistService->getCount(),
        ]);
    }
}
