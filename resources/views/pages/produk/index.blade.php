@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-ink/50 mb-4" aria-label="Breadcrumb">
        <a href="{{ url('/') }}" class="hover:text-walnut transition-colors">Beranda</a>
        <span class="mx-2">/</span>
        @if($activeCategory ?? null)
            <a href="{{ route('produk.index') }}" class="hover:text-walnut transition-colors">Produk</a>
            <span class="mx-2">/</span>
            <span class="text-ink/80">{{ $activeCategory->name }}</span>
        @else
            <span class="text-ink/80">Produk</span>
        @endif
    </nav>

    {{-- Header halaman --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
        <div>
            <h1 class="font-display text-3xl sm:text-4xl font-semibold text-ink">
                {{ $activeCategory->name ?? 'Semua Produk' }}
            </h1>
            <p class="mt-2 text-ink/60">
                {{ $products->total() }} produk ditemukan
                @if(request('q'))
                    untuk pencarian "<span class="text-ink/80">{{ request('q') }}</span>"
                @endif
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- ============ SIDEBAR FILTER ============ --}}
        <aside class="lg:col-span-3">
            <form method="GET" action="{{ url()->current() }}" class="space-y-8">

                {{-- Pencarian --}}
                <div>
                    <label for="q" class="block text-sm font-semibold text-ink mb-2">Cari</label>
                    <input
                        type="text" name="q" id="q" value="{{ request('q') }}"
                        placeholder="Cari nama produk..."
                        class="w-full rounded-md border border-walnut/20 bg-white/60 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-walnut/30"
                    >
                </div>

                {{-- Kategori --}}
                <div>
                    <h3 class="text-sm font-semibold text-ink mb-3">Kategori</h3>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a
                                href="{{ route('produk.index', request()->except(['kategori', 'page'])) }}"
                                class="{{ !($activeCategory ?? null) ? 'text-walnut font-medium' : 'text-ink/60 hover:text-walnut' }} transition-colors"
                            >
                                Semua Kategori
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a
                                    href="{{ route('kategori.show', array_merge(request()->except(['kategori', 'page']), ['category' => $category->slug])) }}"
                                    class="{{ ($activeCategory ?? null)?->slug === $category->slug ? 'text-walnut font-medium' : 'text-ink/60 hover:text-walnut' }} transition-colors"
                                >
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Rentang harga --}}
                <div>
                    <h3 class="text-sm font-semibold text-ink mb-3">Rentang Harga</h3>
                    <div class="flex items-center gap-2">
                        <input
                            type="number" name="min" value="{{ request('min') }}" placeholder="Min"
                            class="w-full rounded-md border border-walnut/20 bg-white/60 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-walnut/30"
                        >
                        <span class="text-ink/30">&ndash;</span>
                        <input
                            type="number" name="max" value="{{ request('max') }}" placeholder="Max"
                            class="w-full rounded-md border border-walnut/20 bg-white/60 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-walnut/30"
                        >
                    </div>
                </div>

                {{-- Material --}}
                @if(($materials ?? collect())->isNotEmpty())
                    <div>
                        <h3 class="text-sm font-semibold text-ink mb-3">Material</h3>
                        <select
                            name="material"
                            class="w-full rounded-md border border-walnut/20 bg-white/60 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-walnut/30"
                        >
                            <option value="">Semua Material</option>
                            @foreach($materials as $material)
                                <option value="{{ $material }}" @selected(request('material') === $material)>
                                    {{ $material }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- Simpan sort yang aktif supaya tidak reset saat submit filter --}}
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                <button
                    type="submit"
                    class="w-full bg-walnut text-canvas font-medium text-sm py-2.5 rounded-md hover:bg-walnut-dark transition-colors"
                >
                    Terapkan Filter
                </button>

                @if(request()->anyFilled(['q', 'min', 'max', 'material', 'kategori']))
                    <a
                        href="{{ route('produk.index') }}"
                        class="block text-center text-xs text-ink/50 hover:text-rust transition-colors"
                    >
                        Reset semua filter
                    </a>
                @endif
            </form>
        </aside>

        {{-- ============ GRID PRODUK ============ --}}
        <div class="lg:col-span-9">

            {{-- Urutkan --}}
            <div class="flex justify-end mb-6">
                <form method="GET" action="{{ url()->current() }}" id="sort-form">
                    @foreach(request()->except(['sort', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select
                        name="sort"
                        onchange="document.getElementById('sort-form').submit()"
                        class="rounded-md border border-walnut/20 bg-white/60 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-walnut/30"
                    >
                        <option value="terbaru" @selected(request('sort', 'terbaru') === 'terbaru')>Terbaru</option>
                        <option value="termurah" @selected(request('sort') === 'termurah')>Harga Termurah</option>
                        <option value="termahal" @selected(request('sort') === 'termahal')>Harga Termahal</option>
                        <option value="terlaris" @selected(request('sort') === 'terlaris')>Terlaris</option>
                    </select>
                </form>
            </div>

            @if($products->isEmpty())
                {{-- Empty state --}}
                <div class="flex flex-col items-center justify-center text-center py-24 border border-dashed border-walnut/20 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-walnut/30 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <h3 class="font-display text-lg text-ink mb-1">Produk tidak ditemukan</h3>
                    <p class="text-sm text-ink/50 max-w-sm">
                        Coba ubah kata kunci pencarian atau filter yang dipakai.
                    </p>
                    <a href="{{ route('produk.index') }}" class="mt-4 text-sm text-walnut font-medium hover:text-walnut-dark transition-colors">
                        Lihat semua produk &rarr;
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
