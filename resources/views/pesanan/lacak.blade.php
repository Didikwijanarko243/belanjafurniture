{{-- resources/views/pesanan/lacak.blade.php --}}
@extends('layouts.app')

@section('title', 'Lacak Pesanan')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="text-center mb-8">
        <h1 class="font-fraunces text-3xl text-walnut mb-2">Lacak Pesanan</h1>
        <p class="text-walnut/60">Masukkan nomor pesanan yang kamu terima via WhatsApp untuk melihat status.</p>
    </div>

    <form method="POST" action="{{ route('orders.track.search') }}" class="flex gap-3 mb-2">
        @csrf
        <input type="text" name="order_number" value="{{ old('order_number') }}"
            placeholder="Contoh: NAIMA-A1B2C3D4"
            class="flex-1 rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm uppercase placeholder:normal-case">
        <button type="submit" class="px-6 py-2.5 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors whitespace-nowrap">
            Cari Pesanan
        </button>
    </form>

    @error('order_number')
        <p class="text-sm text-rust mb-6">{{ $message }}</p>
    @enderror

    @isset($order)
        <div class="mt-10 rounded-xl border border-walnut/10 bg-white/60 p-6">
            {{-- Header info order --}}
            <div class="flex items-center justify-between flex-wrap gap-3 mb-6 pb-6 border-b border-walnut/10">
                <div>
                    <p class="text-xs uppercase tracking-wide text-walnut/40">Nomor Pesanan</p>
                    <p class="font-fraunces text-lg text-walnut">{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs uppercase tracking-wide text-walnut/40">Tanggal Pesan</p>
                    <p class="text-sm text-walnut/70">{{ $order->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            {{-- Status timeline --}}
            @include('pesanan.partials.status-timeline', ['order' => $order])

            {{-- Daftar item --}}
            <div class="mt-8">
                <h2 class="font-fraunces text-lg text-walnut mb-4">Detail Pesanan</h2>
                <div class="space-y-3">
                    @foreach ($order->items as $item)
                        <div class="flex items-center gap-4 rounded-lg border border-walnut/10 p-3">
                            @if ($item->product?->primaryImage->first())
                                <img src="{{ Storage::url($item->product->primaryImage->first()->image_path) }}"
                                    alt="{{ $item->product->name }}"
                                    class="w-14 h-14 rounded-lg object-cover border border-walnut/10 shrink-0">
                            @else
                                <div class="w-14 h-14 rounded-lg bg-walnut/5 shrink-0"></div>
                            @endif
                            <div class="flex-1">
                                <p class="text-walnut font-medium">{{ $item->product->name ?? 'Produk tidak tersedia' }}</p>
                                <p class="text-sm text-walnut/50">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-medium text-walnut">
                                Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center mt-4 pt-4 border-t border-walnut/10">
                    <span class="text-walnut font-medium">Total</span>
                    <span class="font-fraunces text-lg text-rust">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Form ulasan untuk item yang sudah selesai & belum direview --}}
            @if ($order->status === 'completed' && $pendingReviewItems->isNotEmpty())
                @include('pesanan.partials.review-form', ['order' => $order, 'pendingItems' => $pendingReviewItems])
            @endif
        </div>
    @endisset
</div>
@endsection

@push('scripts')
    @isset($order)
        @vite('resources/js/modules/review.js')
    @endisset
@endpush