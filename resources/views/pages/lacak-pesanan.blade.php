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

        <form action="{{ route('order.track') }}" method="POST" class="flex gap-3 mb-10">
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
        @endif
    </div>
</section>
@endsection