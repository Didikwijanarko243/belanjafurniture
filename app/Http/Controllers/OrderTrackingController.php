<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function __construct(protected ReviewService $reviewService) {}

    public function index()
    {
        return view('pesanan.lacak');
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'order_number' => ['required', 'string'],
        ], [
            'order_number.required' => 'Masukkan nomor pesanan kamu.',
        ]);

        $order = Order::where('order_number', trim($validated['order_number']))
            ->with(['items.product.primaryImage'])
            ->first();

        if (! $order) {
            return back()
                ->withInput()
                ->withErrors(['order_number' => 'Nomor pesanan tidak ditemukan. Periksa kembali kode yang kamu masukkan.']);
        }

        $pendingReviewItems = $order->status === 'completed'
            ? $this->reviewService->itemsPendingReview($order)
            : collect();

        return view('pesanan.lacak', [
            'order' => $order,
            'pendingReviewItems' => $pendingReviewItems,
        ]);
    }
}