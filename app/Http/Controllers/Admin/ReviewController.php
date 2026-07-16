<?php
    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\Review;
    use Illuminate\Http\Request;

    class ReviewController extends Controller
    {
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $reviews = Review::with(['order', 'product'])
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $counts = [
            'pending'  => Review::where('status', 'pending')->count(),
            'approved' => Review::where('status', 'approved')->count(),
            'rejected' => Review::where('status', 'rejected')->count(),
            'all'      => Review::count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'status', 'counts'));
    }

    public function approve(Review $review)
    {
        $review->approve();

        return response()->json([
            'success' => true,
            'message' => 'Ulasan disetujui.',
            'status'  => $review->status,
        ]);
    }

    public function reject(Request $request, Review $review)
    {
        $request->validate([
            'admin_note' => ['nullable', 'string', 'max:500'],
        ]);

        $review->reject($request->admin_note);

        return response()->json([
            'success' => true,
            'message' => 'Ulasan ditolak.',
            'status'  => $review->status,
        ]);
    }
}