@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-ink/50 mb-8" aria-label="Breadcrumb">
        <a href="{{ url('/') }}" class="hover:text-walnut transition-colors">Beranda</a>
        <span class="mx-2">/</span>
        <a href="{{ route('produk.index') }}" class="hover:text-walnut transition-colors">Produk</a>
        @if($product->category)
            <span class="mx-2">/</span>
            <a href="{{ route('kategori.show', $product->category->slug) }}" class="hover:text-walnut transition-colors">
                {{ $product->category->name }}
            </a>
        @endif
        <span class="mx-2">/</span>
        <span class="text-ink/80">{{ $product->name }}</span>
    </nav>

    <div
        class="grid grid-cols-1 lg:grid-cols-2 gap-12"
        id="product-detail"
        data-product-id="{{ $product->id }}"
        data-product-name="{{ $product->name }}"
        data-base-price="{{ $product->final_price }}"
        data-stock="{{ $product->stock }}"
        data-whatsapp-number="{{ config('shop.whatsapp_number') }}"
    >
        {{-- ============ GALERI ============ --}}
        <div>
            <div class="aspect-square rounded-lg overflow-hidden bg-canvas border border-walnut/10">
                @if($product->images->isNotEmpty())
                    <img
                        id="gallery-main-image"
                        src="{{ Storage::url($product->images->first()->image_path) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center text-walnut/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                @endif
            </div>

            @if($product->images->count() > 1)
                <div id="gallery-thumbnails" class="mt-4 grid grid-cols-5 gap-3">
                    @foreach($product->images as $image)
                        <button
                            type="button"
                            class="gallery-thumb aspect-square rounded-md overflow-hidden border-2 {{ $loop->first ? 'border-walnut' : 'border-transparent' }} hover:border-walnut/50 transition-colors"
                            data-full-src="{{ Storage::url($image->image_path) }}"
                        >
                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->alt_text ?? $product->name }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ============ INFO PRODUK ============ --}}
        <div>
            @if($product->category)
                <span class="text-xs uppercase tracking-wide text-sage font-medium">{{ $product->category->name }}</span>
            @endif

            <h1 class="font-display text-3xl sm:text-4xl font-semibold text-ink mt-1">{{ $product->name }}</h1>

            <div class="flex items-center gap-3 mt-3">
                @if($product->average_rating > 0)
                    <div class="flex items-center gap-1.5 text-sm text-ink/60">
                        <x-star-rating :rating="$product->average_rating" />
                        <span>{{ $product->average_rating }} ({{ $product->reviews->count() }} ulasan)</span>
                    </div>
                @endif
                @if($product->sku)
                    <span class="text-xs text-ink/40">SKU: {{ $product->sku }}</span>
                @endif
            </div>

            {{-- Harga --}}
            <div class="flex items-baseline gap-3 mt-5">
                <span id="display-price" class="font-display text-3xl font-semibold text-walnut-dark">
                    Rp{{ number_format($product->final_price, 0, ',', '.') }}
                </span>
                @if($product->sale_price && $product->sale_price < $product->price)
                    <span class="text-base text-ink/40 line-through">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </span>
                @endif
            </div>

            @if($product->short_description)
                <p class="mt-4 text-ink/70 leading-relaxed">{{ $product->short_description }}</p>
            @endif

            <div class="wood-divider my-6"></div>

            {{-- Pilihan varian --}}
            @if($product->variants->isNotEmpty())
                @php
                    $colors = $product->variants->pluck('color')->filter()->unique();
                    $sizes = $product->variants->pluck('size')->filter()->unique();
                @endphp

                @if($colors->isNotEmpty())
                    <div class="mb-5">
                        <span class="block text-sm font-semibold text-ink mb-2">Warna</span>
                        <div class="flex flex-wrap gap-2" id="variant-color-group">
                            @foreach($colors as $color)
                                <button
                                    type="button"
                                    data-variant-color="{{ $color }}"
                                    class="variant-option px-4 py-2 rounded-md border border-walnut/20 text-sm text-ink/70 hover:border-walnut transition-colors"
                                >
                                    {{ $color }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($sizes->isNotEmpty())
                    <div class="mb-5">
                        <span class="block text-sm font-semibold text-ink mb-2">Ukuran</span>
                        <div class="flex flex-wrap gap-2" id="variant-size-group">
                            @foreach($sizes as $size)
                                <button
                                    type="button"
                                    data-variant-size="{{ $size }}"
                                    class="variant-option px-4 py-2 rounded-md border border-walnut/20 text-sm text-ink/70 hover:border-walnut transition-colors"
                                >
                                    {{ $size }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Data varian buat JS (mapping kombinasi warna/ukuran -> stok, harga tambahan) --}}
                <script type="application/json" id="variant-data">
                    {!! $product->variants->map(fn($v) => [
                        'id' => $v->id,
                        'color' => $v->color,
                        'size' => $v->size,
                        'stock' => $v->stock,
                        'additional_price' => $v->additional_price,
                    ])->toJson() !!}
                </script>

                <p id="variant-stock-info" class="text-sm text-ink/50 mb-5"></p>
            @else
                <p class="text-sm text-ink/50 mb-5">
                    @if($product->stock > 0)
                        Stok tersedia: {{ $product->stock }}
                    @else
                        <span class="text-rust">Stok habis</span>
                    @endif
                </p>
            @endif

            {{-- Jumlah --}}
            <div class="mb-6">
                <span class="block text-sm font-semibold text-ink mb-2">Jumlah</span>
                <div class="inline-flex items-center border border-walnut/20 rounded-md">
                    <button type="button" id="qty-decrease" class="w-10 h-10 flex items-center justify-center text-ink/60 hover:text-walnut transition-colors" aria-label="Kurangi jumlah">&minus;</button>
                    <input
                        type="number" id="qty-input" value="1" min="1"
                        class="w-14 h-10 text-center border-x border-walnut/20 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                    >
                    <button type="button" id="qty-increase" class="w-10 h-10 flex items-center justify-center text-ink/60 hover:text-walnut transition-colors" aria-label="Tambah jumlah">&plus;</button>
                </div>
            </div>

            {{-- CTA --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <button
                    type="button"
                    id="btn-add-to-cart"
                    class="flex-1 bg-walnut-dark text-canvas font-medium text-sm py-3 rounded-md hover:bg-walnut transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
                >
                    Tambah ke Keranjang
                </button>
                <a
                    id="btn-whatsapp-order"
                    href="#"
                    target="_blank"
                    rel="noopener"
                    class="flex-1 flex items-center justify-center gap-2 bg-sage text-canvas font-medium text-sm py-3 rounded-md hover:opacity-90 transition-opacity"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.28-1.38a9.87 9.87 0 0 0 4.71 1.2h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.5 2 12.04 2zm5.8 14.13c-.24.68-1.4 1.3-1.93 1.38-.5.08-1.12.11-1.8-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.14-4.9-4.33-.14-.19-1.17-1.56-1.17-2.97 0-1.41.74-2.1 1-2.39.26-.29.57-.36.76-.36.19 0 .38 0 .55.01.18.01.41-.07.64.49.24.57.81 1.98.88 2.12.07.14.12.31.02.5-.09.19-.14.31-.28.48-.14.16-.29.36-.42.48-.14.13-.28.28-.12.55.16.28.71 1.17 1.52 1.89 1.05.93 1.93 1.22 2.21 1.36.28.14.44.11.6-.07.16-.18.68-.79.87-1.06.18-.28.37-.23.61-.14.25.1 1.6.75 1.87.89.28.14.46.21.53.32.07.12.07.68-.17 1.36z"/>
                    </svg>
                    Pesan via WhatsApp
                </a>
            </div>

            <div class="wood-divider my-8"></div>

            {{-- Spesifikasi --}}
            <div>
                <h2 class="font-display text-lg font-semibold text-ink mb-4">Spesifikasi</h2>
                <dl class="grid grid-cols-2 gap-y-3 text-sm">
                    @if($product->material)
                        <dt class="text-ink/50">Material</dt>
                        <dd class="text-ink/80">{{ $product->material }}</dd>
                    @endif
                    @if($product->finishing)
                        <dt class="text-ink/50">Finishing</dt>
                        <dd class="text-ink/80">{{ $product->finishing }}</dd>
                    @endif
                    @if($product->dimension)
                        <dt class="text-ink/50">Dimensi</dt>
                        <dd class="text-ink/80">{{ $product->dimension }}</dd>
                    @endif
                    @if($product->weight)
                        <dt class="text-ink/50">Berat</dt>
                        <dd class="text-ink/80">{{ $product->weight }} kg</dd>
                    @endif
                    @if($product->is_custom_order)
                        <dt class="text-ink/50">Estimasi Produksi</dt>
                        <dd class="text-ink/80">{{ $product->production_days }} hari kerja</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    {{-- ============ DESKRIPSI LENGKAP ============ --}}
    @if($product->description)
        <div class="max-w-3xl mt-16">
            <h2 class="font-display text-xl font-semibold text-ink mb-4">Deskripsi Produk</h2>
            <div class="prose prose-sm text-ink/70 leading-relaxed">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>
    @endif

    {{-- ============ ULASAN ============ --}}
    @if($product->reviews->isNotEmpty())
        <div class="mt-16 max-w-3xl">
            <h2 class="font-display text-xl font-semibold text-ink mb-6">
                Ulasan ({{ $product->reviews->count() }})
            </h2>
            <div class="space-y-6">
                @foreach($product->reviews as $review)
                    <div class="border-b border-walnut/10 pb-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium text-sm text-ink">{{ $review->user->name ?? 'Pengguna' }}</span>
                            <span class="text-xs text-ink/40">{{ $review->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                        <x-star-rating :rating="$review->rating" />
                        <p class="text-sm text-ink/70 mt-2 leading-relaxed">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ============ PRODUK TERKAIT ============ --}}
    @if($related->isNotEmpty())
        <div class="mt-20">
            <h2 class="font-display text-2xl font-semibold text-ink mb-6">Produk Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($related as $item)
                    <x-product-card :product="$item" />
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
