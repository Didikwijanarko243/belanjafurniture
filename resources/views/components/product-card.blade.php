@props(['product', 'inWishlist' => null])

@php
    $image = $product->images->first();
    $hasDiscount = $product->sale_price && $product->sale_price < $product->price;
    // Kalau tidak di-pass eksplisit, cek dari $wishlistProductIds yang dikirim view composer global.
    $isWishlisted = $inWishlist ?? (isset($wishlistProductIds) && $wishlistProductIds->contains($product->id));
@endphp

<div class="group relative flex flex-col bg-white/60 border border-walnut/10 rounded-lg overflow-hidden hover:border-walnut/30 hover:shadow-lg hover:shadow-walnut/5 transition-all duration-300">

    {{-- Tombol wishlist — sengaja di luar <a> supaya tidak nested clickable --}}
    <button
        type="button"
        class="wishlist-toggle absolute top-3 right-3 z-10 w-8 h-8 flex items-center justify-center rounded-full bg-canvas/90 backdrop-blur hover:bg-canvas transition-colors"
        data-product-id="{{ $product->id }}"
        aria-label="Simpan ke wishlist"
        aria-pressed="{{ $isWishlisted ? 'true' : 'false' }}"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 wishlist-icon" viewBox="0 0 24 24"
             fill="{{ $isWishlisted ? 'var(--color-rust)' : 'none' }}"
             stroke="{{ $isWishlisted ? 'var(--color-rust)' : 'currentColor' }}"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
    </button>

    <a href="{{ route('produk.show', $product->slug) }}" class="flex flex-col">
        {{-- Gambar --}}
        <div class="relative aspect-square overflow-hidden bg-canvas">
            @if($image)
                <img
                    src="{{ Storage::url($image->image_path) }}"
                    alt="{{ $image->alt_text ?? $product->name }}"
                    loading="lazy"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                >
            @else
                <div class="w-full h-full flex items-center justify-center text-walnut/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path d="M21 15l-5-5L5 21"/>
                    </svg>
                </div>
            @endif

            {{-- Badge diskon & custom, ditumpuk kiri atas biar tidak tabrakan sama tombol wishlist --}}
            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                @if($hasDiscount)
                    <span class="bg-rust text-canvas text-[11px] font-semibold px-2 py-1 rounded w-fit">
                        Diskon
                    </span>
                @endif
                @if($product->is_custom_order)
                    <span class="bg-walnut-dark/90 text-canvas text-[11px] font-medium px-2 py-1 rounded w-fit">
                        Custom
                    </span>
                @endif
            </div>
        </div>

        {{-- Info --}}
        <div class="flex flex-col gap-1.5 p-4">
            @if($product->category)
                <span class="text-[11px] uppercase tracking-wide text-sage font-medium">
                    {{ $product->category->name }}
                </span>
            @endif

            <h3 class="font-display text-base font-medium text-ink leading-snug line-clamp-2">
                {{ $product->name }}
            </h3>

            @if($product->average_rating > 0)
                <div class="flex items-center gap-1 text-xs text-ink/60">
                    <x-star-rating :rating="$product->average_rating" />
                    <span>({{ $product->average_rating }})</span>
                </div>
            @endif

            <div class="mt-1 flex items-baseline gap-2">
                <span class="font-semibold text-walnut-dark">
                    Rp{{ number_format($product->final_price, 0, ',', '.') }}
                </span>
                @if($hasDiscount)
                    <span class="text-xs text-ink/40 line-through">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </span>
                @endif
            </div>

            @if($product->is_custom_order && $product->production_days)
                <span class="text-[11px] text-ink/50">
                    Pesanan custom &middot; {{ $product->production_days }} hari kerja
                </span>
            @endif
        </div>
    </a>
</div>
