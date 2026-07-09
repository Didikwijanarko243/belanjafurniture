<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class CartService
{
    private const SESSION_KEY = 'guest_session_id';

    /**
     * Identitas guest yang persisten selama session browser aktif.
     * Dipakai sebagai session_id di tabel carts (bukan session()->getId()
     * bawaan Laravel, karena itu bisa berubah saat session regenerate).
     */
    public function getSessionId(): string
    {
        if (! session()->has(self::SESSION_KEY)) {
            session([self::SESSION_KEY => (string) Str::uuid()]);
        }

        // dd(self::SESSION_KEY);
        return session(self::SESSION_KEY);
    }

    public function getCurrentCart(): Cart
    {
        return Cart::firstOrCreate(['session_id' => $this->getSessionId()]);
    }

    public function addItem(int $productId, ?int $variantId, int $quantity): CartItem
    {
        $cart = $this->getCurrentCart();
        $product = Product::findOrFail($productId);
        $variant = $variantId ? ProductVariant::findOrFail($variantId) : null;

        $price = $variant ? $variant->final_price : $product->final_price;

        $existing = $cart->items()
            ->where('product_id', $productId)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $quantity);

            return $existing->fresh();
        }

        return $cart->items()->create([
            'product_id' => $productId,
            'product_variant_id' => $variantId,
            'quantity' => $quantity,
            'price' => $price,
        ]);
    }

    public function updateQuantity(CartItem $item, int $quantity): CartItem
    {
        $item->update(['quantity' => max(1, $quantity)]);

        return $item->fresh();
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    public function getItemCount(): int
    {
        return (int) $this->getCurrentCart()->items()->sum('quantity');
    }
}
