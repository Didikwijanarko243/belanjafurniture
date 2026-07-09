@props(['categories'])

<div class="relative" data-mega-menu>
    <button
        type="button"
        class="mega-menu-trigger relative py-2 flex items-center gap-1 text-ink/70 hover:text-walnut transition-colors {{ request()->routeIs('kategori.*') ? 'text-rust font-semibold' : '' }}"
        aria-haspopup="true"
        aria-expanded="false"
    >
        Kategori
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform mega-menu-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"/>
        </svg>
        @if(request()->routeIs('kategori.*'))
            <span class="absolute -bottom-px left-0 right-0 h-0.5 bg-rust rounded-full"></span>
        @endif
    </button>

    <div
        class="mega-menu-panel hidden absolute left-1/2 -translate-x-1/2 top-full mt-3 w-[560px] bg-canvas border border-walnut/10 rounded-lg shadow-xl shadow-walnut/10 p-6 grid grid-cols-3 gap-4 z-40"
        role="menu"
    >
        @forelse($categories as $category)
            <a href="{{ route('kategori.show', $category->slug) }}" class="group flex flex-col gap-2 rounded-md overflow-hidden" role="menuitem">
                <div class="aspect-square rounded-md overflow-hidden bg-white/60 border border-walnut/10">
                    @if($category->image)
                        <img
                            src="{{ Storage::url($category->image) }}"
                            alt="{{ $category->name }}"
                            loading="lazy"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center text-walnut/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="M21 15l-5-5L5 21"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div>
                    <div class="text-sm font-medium text-ink group-hover:text-walnut transition-colors">
                        {{ $category->name }}
                    </div>
                    <div class="text-xs text-ink/50">{{ $category->products_count }} produk</div>
                </div>
            </a>
        @empty
            <p class="col-span-3 text-sm text-ink/50">Belum ada kategori.</p>
        @endforelse
    </div>
</div>