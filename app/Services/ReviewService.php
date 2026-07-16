<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class ReviewService
{
    /**
     * Cari order via nomor order, hanya order yang statusnya selesai/completed
     * yang boleh direview.
     */
    public function findReviewableOrder(string $orderNumber): ?Order
    {
        return Order::where('order_number', $orderNumber)
            ->whereIn('status', ['completed', 'selesai']) // sesuaikan dengan enum status order kamu
            ->with(['items.product', 'items.product.approvedReviews'])
            ->first();
    }

    /**
     * Ambil item order yang belum direview, untuk ditampilkan sebagai
     * form "Beri Ulasan" di halaman lacak pesanan.
     */
    public function itemsPendingReview(Order $order): Collection
    {
        $reviewedProductIds = Review::where('order_id', $order->id)->pluck('product_id');

        return $order->items->reject(
            fn ($item) => $reviewedProductIds->contains($item->product_id)
        );
    }

    public function submit(Order $order, array $data): Review
    {
        $item = $order->items->firstWhere('product_id', $data['product_id']);

        if (! $item) {
            throw ValidationException::withMessages([
                'product_id' => 'Produk tidak ditemukan pada pesanan ini.',
            ]);
        }

        $alreadyReviewed = Review::where('order_id', $order->id)
            ->where('product_id', $data['product_id'])
            ->exists();

        if ($alreadyReviewed) {
            throw ValidationException::withMessages([
                'product_id' => 'Produk ini sudah pernah diulas.',
            ]);
        }

        return Review::create([
            'order_id' => $order->id,
            'product_id' => $data['product_id'],
            'order_item_id' => $item->id,
            'reviewer_name' => $order->customer_name,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
            'status' => 'pending',
        ]);
    }
}