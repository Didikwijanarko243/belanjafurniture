<?php

namespace App\Services;

use App\Models\Wishlist;
use Illuminate\Support\Collection;

class WishlistService
{
    public function __construct(protected CartService $cartService)
    {
        // Pakai session_id yang sama dengan cart, biar konsisten satu identitas per guest.
    }

    protected function sessionId(): string
    {
        // dd($this->cartService->getSessionId());
        return $this->cartService->getSessionId();
    }

    /**
     * Tambah kalau belum ada, hapus kalau sudah ada. Return true = sekarang ada di wishlist.
     */
    public function toggle(int $productId): bool
    {
        // dd($this->sessionId());
        $existing = Wishlist::where('session_id', $this->sessionId())
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();

            return false;
        }

        Wishlist::create([
            'session_id' => $this->sessionId(),
            'product_id' => $productId,
        ]);

        return true;
    }

    public function getProductIds(): Collection
    {
        // dd($this->sessionId());
        return Wishlist::where('session_id', $this->sessionId())->pluck('product_id');
    }

    public function getCount(): int
    {
        return Wishlist::where('session_id', $this->sessionId())->count();
    }
}
