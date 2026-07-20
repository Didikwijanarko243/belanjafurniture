@extends('layouts.app')

@section('content')
<section class="bg-canvas py-20">
    <div class="max-w-2xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="inline-block text-xs font-semibold tracking-[0.2em] uppercase text-brass mb-3">
                Lacak Pesanan
            </span>
            <h1 class="font-display text-3xl sm:text-4xl font-semibold text-walnut">
                Cek status pesanan Anda
            </h1>
        </div>

        <form action="{{ route('orders.track.search') }}" method="POST" class="flex gap-3 mb-10">
            @csrf
            <input type="text" name="order_number" placeholder="Contoh: NAIMA-8F3K2X9P"
                value="{{ old('order_number') }}"
                class="flex-1 rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            <button type="submit"
                class="px-6 py-3 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
                Lacak
            </button>
        </form>

        @if (session('error'))
            <p class="text-center text-sm text-rust mb-8">{{ session('error') }}</p>
        @endif

        @if (session('success'))
            <p class="text-center text-sm text-sage mb-8">{{ session('success') }}</p>
        @endif

        @if (isset($order))
            <div class="bg-white/60 rounded-xl border-t-4 border-sage p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="font-mono text-sm text-walnut/70">{{ $order->order_number }}</span>
                    <span class="text-xs font-semibold uppercase tracking-wide px-3 py-1 rounded-full bg-sage/10 text-sage">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="text-sm text-ink/70 mb-4 space-y-1">
                    <p><span class="font-medium text-walnut">Penerima:</span> {{ $order->customer_name }}</p>
                    <p><span class="font-medium text-walnut">Alamat:</span> {{ $order->customer_address }}</p>
                </div>

                <ul class="divide-y divide-walnut/10 mb-4">
                    @foreach ($order->items as $item)
                        <li class="py-3 flex justify-between text-sm">
                            <span>{{ $item->product_name }}{{ $item->variant_name ? " ({$item->variant_name})" : '' }} x{{ $item->quantity }}</span>
                            <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="flex justify-between font-semibold text-walnut">
                    <span>Total</span>
                    <span>Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            @if (isset($pendingReviewItems) && $pendingReviewItems->isNotEmpty())
                <div class="mt-8 bg-white/60 rounded-xl border-t-4 border-brass p-6 shadow-sm">
                    <h2 class="font-display text-lg font-semibold text-walnut mb-1">Beri Ulasan</h2>
                    <p class="text-sm text-ink/60 mb-6">Pesanan kamu sudah selesai — yuk bagikan pengalamanmu untuk
                        produk berikut.</p>

                    <div class="space-y-8">
                        @foreach ($pendingReviewItems as $item)
                            @php $isThisItem = old('product_id') == $item->product_id; @endphp
                            <form action="{{ route('review.store') }}" method="POST"
                                class="border-t border-walnut/10 pt-6 first:border-t-0 first:pt-0">
                                @csrf
                                <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">

                                <p class="text-sm font-medium text-walnut mb-3">
                                    {{ $item->product_name }}{{ $item->variant_name ? " ({$item->variant_name})" : '' }}
                                </p>

                                <div class="flex flex-row-reverse justify-end gap-1 mb-1">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating"
                                            id="rating-{{ $item->product_id }}-{{ $i }}" value="{{ $i }}"
                                            class="peer sr-only"
                                            {{ $isThisItem && (int) old('rating') === $i ? 'checked' : '' }} required>
                                        <label for="rating-{{ $item->product_id }}-{{ $i }}"
                                            class="cursor-pointer text-2xl text-walnut/20 peer-checked:text-brass hover:text-brass transition-colors">&#9733;</label>
                                    @endfor
                                </div>

                                @if ($isThisItem && $errors->has('rating'))
                                    <p class="text-xs text-rust mb-3">{{ $errors->first('rating') }}</p>
                                @endif

                                <textarea name="comment" rows="3"
                                    placeholder="Ceritakan pengalamanmu dengan produk ini (opsional)"
                                    class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm mb-3">{{ $isThisItem ? old('comment') : '' }}</textarea>

                                @if ($isThisItem && $errors->has('comment'))
                                    <p class="text-xs text-rust mb-3">{{ $errors->first('comment') }}</p>
                                @endif

                                @if ($isThisItem && $errors->has('product_id'))
                                    <p class="text-xs text-rust mb-3">{{ $errors->first('product_id') }}</p>
                                @endif

                                <button type="submit"
                                    class="px-5 py-2 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
                                    Kirim Ulasan
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
</section>
@endsection