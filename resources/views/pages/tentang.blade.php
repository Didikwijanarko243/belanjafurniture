@extends('layouts.app')

@section('content')

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden bg-canvas">
        {{-- aksen garis kayu tipis di kiri, mengulang motif wood-divider di footer --}}
        <div class="absolute inset-y-0 left-0 w-1.5 bg-gradient-to-b from-rust via-brass to-sage"></div>

        <div class="max-w-4xl mx-auto px-6 lg:px-8 pt-20 pb-16 text-center">
            <span class="inline-block text-xs font-semibold tracking-[0.2em] uppercase text-brass mb-4">
                Tentang Kami
            </span>
            <h1 class="font-display text-4xl sm:text-5xl font-semibold text-walnut leading-tight mb-6">
                Dari tenaga ahli yang berpengalaman,<br class="hidden sm:block">
                lahir brankas yang melindungi yang paling berharga
            </h1>
            <p class="text-ink/70 text-lg leading-relaxed max-w-2xl mx-auto">
                Brankas Murah Jombang dibangun oleh tenaga produksi lokal yang percaya bahwa keamanan
                yang baik bukan sekadar kotak baja, tapi ketenangan pikiran keluarga dan bisnis Anda
                selama bertahun-tahun ke depan.
            </p>
        </div>
    </section>

    {{-- garis pemisah bertekstur kayu, konsisten dengan divider sebelum footer --}}
    <div class="wood-divider"></div>

    {{-- ============ VALUE / KEUNGGULAN ============ --}}
    <section class="bg-canvas py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="inline-block text-xs font-semibold tracking-[0.2em] uppercase text-brass mb-3">
                    Kenapa Brankas Murah Jombang
                </span>
                <h2 class="font-display text-3xl sm:text-4xl font-semibold text-walnut">
                    Keunggulan yang kami jaga di setiap produk
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Card 1 --}}
                <div class="group bg-white/60 rounded-xl border-t-4 border-rust p-7 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-lg bg-rust/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rust" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2l9 4.9V17L12 22l-9-5.1V6.9L12 2z" />
                            <path d="M12 22V12" />
                            <path d="M21 6.9L12 12 3 6.9" />
                        </svg>
                    </div>
                    <h3 class="font-display text-lg font-semibold text-walnut mb-2">Plat Baja Solid Pilihan</h3>
                    <p class="text-sm text-ink/65 leading-relaxed">
                        Kami hanya memakai plat baja dengan ketebalan dan kualitas terukur,
                        sehingga tahan terhadap upaya bongkar paksa dan benturan.
                    </p>
                </div>

                {{-- Card 2 --}}
                <div class="group bg-white/60 rounded-xl border-t-4 border-sage p-7 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-lg bg-sage/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-sage" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20s-7-4.35-9.5-8.5C1 8 2.5 4.5 6 4.5c2 0 3.5 1.2 4 2 .5-.8 2-2 4-2 3.5 0 5 3.5 3.5 7C19 15.65 12 20 12 20z" />
                        </svg>
                    </div>
                    <h3 class="font-display text-lg font-semibold text-walnut mb-2">Diproduksi Langsung Tenaga Ahli</h3>
                    <p class="text-sm text-ink/65 leading-relaxed">
                        Setiap brankas dirakit dan dilas oleh tenaga produksi berpengalaman,
                        menjaga kualitas sambungan dan sistem kunci di setiap unit.
                    </p>
                </div>

                {{-- Card 3 --}}
                <div class="group bg-white/60 rounded-xl border-t-4 border-brass p-7 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-lg bg-brass/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-brass" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="16" rx="2" />
                            <path d="M3 9h18" />
                            <path d="M8 4v5" />
                            <path d="M16 4v5" />
                        </svg>
                    </div>
                    <h3 class="font-display text-lg font-semibold text-walnut mb-2">Bisa Custom Ukuran & Sistem Kunci</h3>
                    <p class="text-sm text-ink/65 leading-relaxed">
                        Kebutuhan setiap rumah dan bisnis berbeda. Kami melayani pemesanan custom ukuran,
                        jenis kunci (kombinasi, kunci pas, elektronik), dan kapasitas sesuai kebutuhan Anda.
                    </p>
                </div>

                {{-- Card 4 --}}
                <div class="group bg-white/60 rounded-xl border-t-4 border-rust p-7 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-lg bg-rust/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rust" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2l3 6 6 .9-4.5 4.2 1.1 6-5.6-3-5.6 3 1.1-6L3 8.9 9 8l3-6z" />
                        </svg>
                    </div>
                    <h3 class="font-display text-lg font-semibold text-walnut mb-2">Tahan Api & Anti Karat</h3>
                    <p class="text-sm text-ink/65 leading-relaxed">
                        Lapisan pelindung dan konstruksi kami dirancang agar tahan terhadap panas dan
                        kelembapan, menjaga dokumen serta barang berharga tetap aman.
                    </p>
                </div>

                {{-- Card 5 --}}
                <div class="group bg-white/60 rounded-xl border-t-4 border-sage p-7 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-lg bg-sage/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-sage" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12l2 2 4-4" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </div>
                    <h3 class="font-display text-lg font-semibold text-walnut mb-2">Garansi & Layanan Purna Jual</h3>
                    <p class="text-sm text-ink/65 leading-relaxed">
                        Kami tetap mendampingi setelah brankas sampai — mulai dari garansi kunci dan
                        konstruksi hingga bantuan servis di lokasi Anda.
                    </p>
                </div>

                {{-- Card 6 --}}
                <div class="group bg-white/60 rounded-xl border-t-4 border-brass p-7 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-lg bg-brass/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-brass" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23" />
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                    </div>
                    <h3 class="font-display text-lg font-semibold text-walnut mb-2">Harga Transparan, Langsung dari Produsen</h3>
                    <p class="text-sm text-ink/65 leading-relaxed">
                        Sebagai produsen sekaligus penjual, kami memangkas rantai perantara sehingga
                        harga yang Anda bayar sesuai dengan kualitas dan keamanan yang Anda terima.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- ============ CTA ============ --}}
    <section class="bg-walnut-dark">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 py-16 text-center">
            <h2 class="font-display text-2xl sm:text-3xl font-semibold text-canvas mb-4">
                Siap menemukan brankas yang pas untuk kebutuhan Anda?
            </h2>
            <p class="text-canvas/70 mb-8 max-w-xl mx-auto">
                Jelajahi koleksi kami atau hubungi tim Brankas Murah Jombang untuk konsultasi ukuran dan tipe kunci.
            </p>
            <div class="flex items-center justify-center gap-4 flex-wrap">
                <a href="{{ route('produk.index') }}"
                    class="inline-flex items-center px-6 py-3 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
                    Lihat Koleksi Produk
                </a>
                <a href="{{ url('/kontak') }}"
                    class="inline-flex items-center px-6 py-3 rounded-lg border border-canvas/30 text-canvas text-sm font-semibold hover:bg-canvas/10 transition-colors">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

@endsection