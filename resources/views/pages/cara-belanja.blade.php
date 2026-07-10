@extends('layouts.app')

@section('content')

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden bg-canvas">
        <div class="absolute inset-y-0 left-0 w-1.5 bg-gradient-to-b from-rust via-brass to-sage"></div>

        <div class="max-w-4xl mx-auto px-6 lg:px-8 pt-20 pb-14 text-center">
            <span class="inline-block text-xs font-semibold tracking-[0.2em] uppercase text-brass mb-4">
                Cara Belanja
            </span>
            <h1 class="font-display text-4xl sm:text-5xl font-semibold text-walnut leading-tight mb-6">
                Belanja mudah, dibantu langsung oleh tim kami
            </h1>
            <p class="text-ink/70 text-lg leading-relaxed max-w-2xl mx-auto">
                Setiap pesanan kami tangani manual lewat WhatsApp, supaya ukuran, warna, dan detail
                furniture Anda benar-benar sesuai sebelum dikirim.
            </p>
        </div>
    </section>

    <div class="wood-divider"></div>

    {{-- ============ LANGKAH-LANGKAH ============ --}}
    <section class="bg-canvas py-20">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">

            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="inline-block text-xs font-semibold tracking-[0.2em] uppercase text-brass mb-3">
                    Alur Pemesanan
                </span>
                <h2 class="font-display text-3xl sm:text-4xl font-semibold text-walnut">
                    5 langkah dari lihat produk sampai furniture sampai di rumah
                </h2>
            </div>

            <div class="relative">
                {{-- garis timeline vertikal --}}
                <div class="hidden sm:block absolute left-7 top-2 bottom-2 w-px bg-walnut/15"></div>

                <div class="space-y-10">

                    {{-- Langkah 1 --}}
                    <div class="relative flex gap-6">
                        <div class="shrink-0 w-14 h-14 rounded-full bg-rust text-canvas flex items-center justify-center font-display text-lg font-semibold z-10">
                            01
                        </div>
                        <div class="bg-white/60 rounded-xl border-t-4 border-rust p-6 shadow-sm flex-1">
                            <h3 class="font-display text-lg font-semibold text-walnut mb-2">Jelajahi & Pilih Produk</h3>
                            <p class="text-sm text-ink/65 leading-relaxed">
                                Lihat katalog di halaman <a href="{{ route('produk.index') }}" class="text-rust font-medium hover:underline">Produk</a>,
                                gunakan menu kategori untuk mempersempit pilihan sesuai kebutuhan ruangan Anda.
                            </p>
                        </div>
                    </div>

                    {{-- Langkah 2 --}}
                    <div class="relative flex gap-6">
                        <div class="shrink-0 w-14 h-14 rounded-full bg-sage text-canvas flex items-center justify-center font-display text-lg font-semibold z-10">
                            02
                        </div>
                        <div class="bg-white/60 rounded-xl border-t-4 border-sage p-6 shadow-sm flex-1">
                            <h3 class="font-display text-lg font-semibold text-walnut mb-2">Simpan ke Wishlist</h3>
                            <p class="text-sm text-ink/65 leading-relaxed">
                                Tandai produk yang Anda minati dengan ikon hati agar mudah dibandingkan atau
                                dibuka kembali sebelum menghubungi kami.
                            </p>
                        </div>
                    </div>

                    {{-- Langkah 3 --}}
                    <div class="relative flex gap-6">
                        <div class="shrink-0 w-14 h-14 rounded-full bg-brass text-canvas flex items-center justify-center font-display text-lg font-semibold z-10">
                            03
                        </div>
                        <div class="bg-white/60 rounded-xl border-t-4 border-brass p-6 shadow-sm flex-1">
                            <h3 class="font-display text-lg font-semibold text-walnut mb-2">Konsultasi via WhatsApp</h3>
                            <p class="text-sm text-ink/65 leading-relaxed">
                                Chat tim kami untuk konfirmasi stok, harga, opsi custom ukuran/warna, serta
                                estimasi ongkos kirim ke lokasi Anda.
                            </p>
                        </div>
                    </div>

                    {{-- Langkah 4 --}}
                    <div class="relative flex gap-6">
                        <div class="shrink-0 w-14 h-14 rounded-full bg-rust text-canvas flex items-center justify-center font-display text-lg font-semibold z-10">
                            04
                        </div>
                        <div class="bg-white/60 rounded-xl border-t-4 border-rust p-6 shadow-sm flex-1">
                            <h3 class="font-display text-lg font-semibold text-walnut mb-2">Kesepakatan & Pembayaran</h3>
                            <p class="text-sm text-ink/65 leading-relaxed">
                                Setelah detail pesanan disepakati, pembayaran dapat dilakukan via transfer bank
                                atau COD, tergantung lokasi pengiriman.
                            </p>
                        </div>
                    </div>

                    {{-- Langkah 5 --}}
                    <div class="relative flex gap-6">
                        <div class="shrink-0 w-14 h-14 rounded-full bg-sage text-canvas flex items-center justify-center font-display text-lg font-semibold z-10">
                            05
                        </div>
                        <div class="bg-white/60 rounded-xl border-t-4 border-sage p-6 shadow-sm flex-1">
                            <h3 class="font-display text-lg font-semibold text-walnut mb-2">Produksi & Pengiriman</h3>
                            <p class="text-sm text-ink/65 leading-relaxed">
                                Furniture dikirim menggunakan ekspedisi standar atau armada kami sendiri,
                                menyesuaikan lokasi dan ukuran barang, sampai tiba dengan aman di rumah Anda.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="wood-divider"></div>

    {{-- ============ PEMBAYARAN & PENGIRIMAN ============ --}}
    <section class="bg-canvas py-20">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 gap-6">

            <div class="bg-white/60 rounded-xl border-t-4 border-brass p-7 shadow-sm">
                <div class="w-11 h-11 rounded-lg bg-brass/10 flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-brass" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2" />
                        <line x1="2" y1="10" x2="22" y2="10" />
                    </svg>
                </div>
                <h3 class="font-display text-lg font-semibold text-walnut mb-3">Metode Pembayaran</h3>
                <ul class="text-sm text-ink/65 space-y-2">
                    <li class="flex items-start gap-2">
                        <span class="text-brass mt-1">•</span>
                        <span>Transfer bank ke rekening resmi Naima Furniture</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-brass mt-1">•</span>
                        <span>Bayar di tempat (COD) untuk area jangkauan tertentu</span>
                    </li>
                </ul>
                {{-- TODO: tambahkan detail rekening bank & syarat COD per area --}}
            </div>

            <div class="bg-white/60 rounded-xl border-t-4 border-rust p-7 shadow-sm">
                <div class="w-11 h-11 rounded-lg bg-rust/10 flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rust" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13" rx="1" />
                        <path d="M16 8h4l3 3v5h-7V8z" />
                        <circle cx="5.5" cy="18.5" r="2.5" />
                        <circle cx="18.5" cy="18.5" r="2.5" />
                    </svg>
                </div>
                <h3 class="font-display text-lg font-semibold text-walnut mb-3">Pengiriman</h3>
                <ul class="text-sm text-ink/65 space-y-2">
                    <li class="flex items-start gap-2">
                        <span class="text-rust mt-1">•</span>
                        <span>Ekspedisi standar untuk luar kota / barang berukuran umum</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-rust mt-1">•</span>
                        <span>Armada pengiriman sendiri untuk area tertentu atau barang berukuran besar</span>
                    </li>
                </ul>
                {{-- TODO: sebutkan cakupan area armada sendiri & estimasi lama pengiriman --}}
            </div>

        </div>
    </section>

    {{-- ============ CTA ============ --}}
    <section class="bg-walnut-dark">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 py-16 text-center">
            <h2 class="font-display text-2xl sm:text-3xl font-semibold text-canvas mb-4">
                Sudah menemukan produk yang cocok?
            </h2>
            <p class="text-canvas/70 mb-8 max-w-xl mx-auto">
                Hubungi kami via WhatsApp untuk mulai proses pemesanan.
            </p>
            <a href="https://wa.me/{{ config('shop.whatsapp_number', '6281200000000') }}" target="_blank" rel="noopener"
                class="inline-flex items-center px-6 py-3 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
                Chat via WhatsApp
            </a>
        </div>
    </section>

@endsection
