@props(['product'])

<a href="{{ route('produk.show', $product->slug) }}" {{ $attributes->merge(['class' => 'group block']) }}>
    <div class="aspect-square bg-walnut/5 rounded-xl overflow-hidden mb-3 relative">
        @if($product->sale_price)
            <span class="absolute top-3 left-3 z-10 px-2 py-1 bg-rust text-canvas text-xs font-semibold rounded">
                Diskon
            </span>
        @endif

        @if($product->images->first())
            @php $imgPath = $product->images->first()->image_path; @endphp
            <img src="{{ str_starts_with($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}"
                 alt="{{ $product->images->first()->alt_text ?? $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center text-ink/20 text-xs">Foto</div>
        @endif
    </div>

    <h3 class="font-medium text-ink group-hover:text-rust transition-colors">
        {{ $product->name }}
    </h3>

    @if($product->dimension)
        <p class="text-xs text-ink/50 mt-0.5">{{ $product->dimension }}</p>
    @endif

    <p class="text-rust font-semibold mt-1">
        Rp {{ number_format($product->final_price, 0, ',', '.') }}
        @if($product->sale_price)
            <span class="text-xs text-ink/40 line-through font-normal ml-1">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </span>
        @endif
    </p>
</a>
