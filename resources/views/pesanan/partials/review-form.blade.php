{{-- resources/views/pesanan/partials/review-form.blade.php --}}
<div class="mt-8 border-t border-walnut/10 pt-6">
    <h3 class="font-fraunces text-lg text-walnut mb-4">Beri Ulasan Produk</h3>

    @if (session('success'))
        <p class="rounded-lg bg-sage/10 text-sage text-sm px-4 py-3 mb-4">{{ session('success') }}</p>
    @endif

    @foreach ($pendingItems as $item)
        <div class="review-item mb-4 rounded-lg border border-walnut/10 p-4" data-review-item>
            <div class="flex items-center justify-between">
                <span class="font-medium text-walnut">{{ $item->product->name }}</span>
                <button type="button" class="text-sm text-rust hover:underline" data-review-toggle>
                    Beri Ulasan
                </button>
            </div>

            <form method="POST" action="{{ route('reviews.store') }}"
                class="review-form mt-4 space-y-3 hidden" data-review-form>
                @csrf
                <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                <input type="hidden" name="rating" value="0" data-rating-input>

                <div class="flex gap-1" data-rating-stars>
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" class="text-2xl text-walnut/20" data-star="{{ $i }}">★</button>
                    @endfor
                </div>
                <p class="text-sm text-rust hidden" data-rating-error>Pilih rating dulu ya.</p>

                <textarea name="comment" rows="3" placeholder="Ceritakan pengalaman kamu dengan produk ini..."
                    class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm"></textarea>

                <button type="submit" class="px-4 py-2.5 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
                    Kirim Ulasan
                </button>
            </form>
        </div>
    @endforeach
</div>