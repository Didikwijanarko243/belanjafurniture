<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(protected ReviewService $reviewService) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => ['required', 'string'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $order = $this->reviewService->findReviewableOrder($validated['order_number']);

        if (! $order) {
            return back()->withErrors(['order_number' => 'Pesanan tidak ditemukan atau belum bisa diulas.']);
        }

        $this->reviewService->submit($order, $validated);

        return back()->with('success', 'Terima kasih! Ulasan kamu sedang menunggu persetujuan admin.');
    }
}