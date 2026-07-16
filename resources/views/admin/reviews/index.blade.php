{{-- resources/views/admin/reviews/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Ulasan')
@section('page-title', 'Kelola Ulasan')

@section('content')
<div class="flex items-center justify-between gap-4 mb-6">
    <div class="flex gap-2" data-review-tabs>
        @foreach(['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'all' => 'Semua'] as $key => $label)
            <a href="{{ route('admin.reviews.index', ['status' => $key]) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
               {{ $status === $key ? 'bg-rust text-canvas' : 'bg-walnut/10 text-walnut hover:bg-walnut/15' }}">
                {{ $label }}
                <span class="{{ $status === $key ? 'text-canvas/70' : 'text-ink/40' }}">
                    ({{ $counts[$key] }})
                </span>
            </a>
        @endforeach
    </div>
</div>

<div id="review-toast" class="hidden fixed top-4 right-4 z-50 rounded-lg bg-sage px-4 py-2 text-sm text-canvas shadow-lg"></div>

<div class="bg-white/60 rounded-xl border border-walnut/10 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-walnut/10 text-left text-xs uppercase tracking-wide text-ink/50">
                <th class="px-6 py-3 font-medium">Produk</th>
                <th class="px-6 py-3 font-medium">Order</th>
                <th class="px-6 py-3 font-medium">Nama</th>
                <th class="px-6 py-3 font-medium">Rating</th>
                <th class="px-6 py-3 font-medium">Komentar</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-walnut/10">
            @forelse ($reviews as $review)
                <tr class="hover:bg-canvas/60 transition-colors" data-review-row="{{ $review->id }}">
                    <td class="px-6 py-4">
                        <span class="text-walnut font-medium">{{ $review->product->name }}</span>
                    </td>
                    <td class="px-6 py-4 text-ink/60">{{ $review->order->order_number }}</td>
                    <td class="px-6 py-4 text-ink/70">{{ $review->reviewer_name }}</td>
                    <td class="px-6 py-4">
                        <span class="text-brass">{{ str_repeat('★', $review->rating) }}</span><span class="text-walnut/20">{{ str_repeat('★', 5 - $review->rating) }}</span>
                    </td>
                    <td class="px-6 py-4 max-w-xs">
                        @if ($review->comment)
                            <button type="button" class="text-left text-ink/60 hover:text-walnut truncate block max-w-xs"
                                    data-comment-toggle title="Klik untuk baca lengkap">
                                {{ \Illuminate\Support\Str::limit($review->comment, 40) }}
                            </button>
                            <p class="hidden mt-1 text-ink/60 whitespace-pre-line" data-comment-full>{{ $review->comment }}</p>
                        @else
                            <span class="text-ink/30">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span data-status-badge
                              class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                              {{ match($review->status) {
                                  'pending' => 'bg-brass/10 text-brass',
                                  'approved' => 'bg-sage/10 text-sage',
                                  'rejected' => 'bg-walnut/10 text-walnut/60',
                              } }}">
                            {{ ucfirst($review->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-3" data-review-actions>
                        @if ($review->status === 'pending')
                            <button type="button" class="text-sage text-sm font-medium hover:underline"
                                    data-action="approve" data-review-id="{{ $review->id }}">
                                Setujui
                            </button>
                            <button type="button" class="text-rust/70 text-sm font-medium hover:underline"
                                    data-action="reject" data-review-id="{{ $review->id }}">
                                Tolak
                            </button>
                        @else
                            <span class="text-ink/40 text-xs">Selesai diproses</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-ink/50">Tidak ada ulasan di kategori ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($reviews->hasPages())
    <div class="mt-6">
        {{ $reviews->appends(request()->query())->links() }}
    </div>
@endif

{{-- Modal alasan tolak --}}
<div id="reject-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-walnut/40 p-4">
    <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
        <h3 class="font-fraunces text-lg text-walnut mb-3">Tolak Ulasan</h3>
        <p class="text-sm text-ink/60 mb-3">Beri catatan alasan (opsional, hanya untuk internal).</p>
        <textarea id="reject-note" rows="3"
                  class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm mb-4"
                  placeholder="Contoh: spam, tidak relevan, dsb."></textarea>
        <div class="flex justify-end gap-2">
            <button type="button" id="reject-cancel"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-walnut/60 hover:bg-walnut/5">
                Batal
            </button>
            <button type="button" id="reject-confirm"
                    class="px-4 py-2.5 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
                Tolak Ulasan
            </button>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection