@extends('layouts.app')

@section('content')
    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block text-sm font-medium text-rust tracking-wide uppercase mb-4">
                    Brankas Tahan Api
                </span>
                <h1 class="font-display text-5xl lg:text-6xl leading-tight text-ink mb-6">
                    Keamanan terbaik untuk setiap aset berharga.
                </h1>
                <p class="text-ink/70 text-lg leading-relaxed mb-8 max-w-lg">
                    Perlindungan andal dengan konstruksi kokoh dan ketahanan terhadap api, untuk ketenangan rumah dan bisnis
                    Anda.
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('produk.index') }}"
                        class="inline-flex items-center px-7 py-3.5 bg-rust hover:bg-rust-dark text-canvas font-semibold rounded-lg transition-colors">
                        Lihat Semua Produk
                    </a>
                    <a href="{{ url('/tentang') }}"
                        class="inline-flex items-center px-7 py-3.5 border border-walnut/20 hover:border-walnut/40 text-ink font-semibold rounded-lg transition-colors">
                        Tentang Kami
                    </a>
                </div>
            </div>

            <div class="relative">
                <div class="aspect-[4/5] bg-walnut/10 rounded-2xl flex items-center justify-center">
                    <span class="text-ink/30 text-sm">Gambar produk unggulan di sini</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ TRUST BADGES ============ --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-20">
        <x-trust-badges />
    </section>

    <div class="wood-divider"></div>

    {{-- ============ KATEGORI ============ --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-20">
        <x-section-heading title="Temukan Brankas yang Tepat"
            subtitle="Pilih kategori brankas yang dirancang untuk memberikan perlindungan maksimal bagi dokumen, uang tunai, dan barang berharga Anda." />

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($categories ?? [] as $category)
                <x-category-card :category="$category" />
            @empty
                <p class="col-span-full text-ink/50 text-sm">
                    Belum ada kategori. Tambahkan lewat seeder atau admin panel.
                </p>
            @endforelse
        </div>
    </section>

    <div class="wood-divider"></div>

    {{-- ============ PRODUK UNGGULAN ============ --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-20">
        <x-section-heading title="Produk Unggulan" subtitle="Pilihan favorit pelanggan kami." />

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredProducts ?? [] as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="col-span-full text-ink/50 text-sm">
                    Belum ada produk unggulan. Set <code class="bg-walnut/10 px-1.5 py-0.5 rounded">is_featured</code> ke
                    true di beberapa produk.
                </p>
            @endforelse
        </div>
    </section>

    <div class="wood-divider"></div>

    {{-- ============ TESTIMONI ============ --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-20">
        <x-section-heading align="center" eyebrow="Kata Pelanggan" title="Dipercaya untuk melindungi aset berharga mereka."
            class="mx-auto" />

        <div class="grid lg:grid-cols-3 gap-6">
            @forelse($testimonials ?? [] as $testimonial)
                <x-testimonial-card :name="$testimonial->name" :role="$testimonial->role ?? null" :comment="$testimonial->comment" :rating="$testimonial->rating" />
            @empty
                <x-testimonial-card name="Rina W." role="Surabaya"
                    comment="Meja makannya kokoh dan seratnya cantik banget, sesuai foto." :rating="5" />
                <x-testimonial-card name="Andi P." role="Malang"
                    comment="Pengiriman aman walau ukurannya besar, dikemas rapi." :rating="5" />
                <x-testimonial-card name="Dewi S." role="Sidoarjo" comment="Respon WhatsApp cepat, custom ukuran juga bisa."
                    :rating="4" />
            @endforelse
        </div>
    </section>

    {{-- ============ CTA PENUTUP ============ --}}
    <section class="bg-walnut-dark">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16 text-center">
            <h2 class="font-display text-3xl text-canvas mb-4">
                Lindungi yang Paling Berharga, Mulai Hari Ini
            </h2>
            <p class="text-canvas/70 mb-8 max-w-lg mx-auto">
                Hubungi kami sekarang dan dapatkan rekomendasi brankas terbaik sesuai kebutuhan Anda.
            </p>
            <a href="{{ 'https://wa.me/' . config('shop.whatsapp_number', '6281200000000') }}"
                class="inline-flex items-center px-7 py-3.5 bg-rust hover:bg-rust-dark text-canvas font-semibold rounded-lg transition-colors">
                Chat via WhatsApp
            </a>
        </div>
    </section>
@endsection
