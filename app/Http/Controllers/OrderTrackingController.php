<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    protected array $reviewableStatuses = ['completed', 'selesai'];

    public function __construct(protected ReviewService $reviewService)
    {}

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

        $orderNumber = trim($validated['order_number']);

        $exists = Order::where('order_number', $orderNumber)->exists();

        if (! $exists) {
            return back()
                ->withInput()
                ->withErrors(['order_number' => 'Nomor pesanan tidak ditemukan. Periksa kembali kode yang kamu masukkan.']);
        }

        // Redirect ke URL GET yang bisa di-bookmark, supaya submit ulasan bisa
        // redirect balik ke halaman ini tanpa nyangkut di route POST.
        return redirect()->route('orders.show', $orderNumber);
    }

    public function show(string $order_number, ReviewService $reviewService)
    {
        $order = Order::where('order_number', $order_number)
            ->with('items')
            ->firstOrFail();

        $pendingReviewItems = in_array($order->status, ['completed', 'selesai'])
            ? $reviewService->itemsPendingReview($order)
            : collect();

        return view('pages.lacak-pesanan', compact('order', 'pendingReviewItems'));
    }
}
