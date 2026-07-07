@props(['category'])

<a href="{{ route('kategori.show', $category->slug) }}"
   {{ $attributes->merge(['class' => 'group block bg-white/50 border border-walnut/10 rounded-xl overflow-hidden hover:border-rust/40 transition-colors']) }}>
    <div class="aspect-square bg-walnut/5 flex items-center justify-center overflow-hidden">
        @if($category->image)
            <img src="{{ asset('storage/' . $category->image) }}"
                 alt="{{ $category->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <span class="text-ink/20 text-xs">Foto</span>
        @endif
    </div>
    <div class="p-4">
        <h3 class="font-semibold text-ink group-hover:text-rust transition-colors">
            {{ $category->name }}
        </h3>
        @if($category->products_count ?? null)
            <p class="text-xs text-ink/50 mt-0.5">{{ $category->products_count }} produk</p>
        @endif
    </div>
</a>
