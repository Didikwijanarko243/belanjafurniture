@extends('layouts.app')

@section('content')
    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden bg-canvas">
        <div class="absolute inset-y-0 left-0 w-1.5 bg-gradient-to-b from-rust via-brass to-sage"></div>

        <div class="max-w-4xl mx-auto px-6 lg:px-8 pt-20 pb-14 text-center">
            <span class="inline-block text-xs font-semibold tracking-[0.2em] uppercase text-brass mb-4">
                Kontak
            </span>
            <h1 class="font-display text-4xl sm:text-5xl font-semibold text-walnut leading-tight mb-6">
                Ada pertanyaan seputar produk atau custom order?
            </h1>
            <p class="text-ink/70 text-lg leading-relaxed max-w-2xl mx-auto">
                Tim kami siap membantu, mulai dari konsultasi ukuran, pilihan kayu, hingga status
                pesanan Anda.
            </p>
        </div>
    </section>

    <div class="wood-divider"></div>

    {{-- ============ INFO KONTAK + PETA ============ --}}
    <section class="bg-canvas py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                {{-- Kolom kiri: info kontak --}}
                <div class="space-y-6">

                    {{-- WhatsApp --}}
                    <a href="https://wa.me/{{ config('shop.whatsapp_number', '6281200000000') }}" target="_blank"
                        rel="noopener"
                        class="flex items-start gap-4 bg-white/60 rounded-xl border-t-4 border-sage p-6 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 shrink-0 rounded-lg bg-sage/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-sage" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg font-semibold text-walnut mb-1">WhatsApp</h3>
                            <p class="text-sm text-ink/65">{{ config('shop.whatsapp_display', '+62 812-0000-0000') }}</p>
                            <p class="text-xs text-ink/45 mt-1">Respons tercepat untuk pertanyaan produk & pesanan</p>
                        </div>
                    </a>

                    {{-- Email --}}
                    <a href="mailto:{{ config('shop.email', 'halo@kayuna.id') }}"
                        class="flex items-start gap-4 bg-white/60 rounded-xl border-t-4 border-rust p-6 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 shrink-0 rounded-lg bg-rust/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rust" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2" />
                                <path d="M2 7l10 6 10-6" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg font-semibold text-walnut mb-1">Email</h3>
                            <p class="text-sm text-ink/65">{{ config('shop.email', 'halo@kayuna.id') }}</p>
                            <p class="text-xs text-ink/45 mt-1">Untuk kerja sama, reseller, atau pertanyaan detail</p>
                        </div>
                    </a>

                    {{-- Alamat --}}
                    <div class="flex items-start gap-4 bg-white/60 rounded-xl border-t-4 border-brass p-6 shadow-sm">
                        <div class="w-11 h-11 shrink-0 rounded-lg bg-brass/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-brass" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg font-semibold text-walnut mb-1">Workshop & Toko</h3>
                            <p class="text-sm text-ink/65">
                                {{ config('shop.address', 'Jl. Contoh No. 123, Jombang, Jawa Timur') }}
                            </p>
                            {{-- TODO: ganti dengan alamat lengkap workshop Naima --}}
                        </div>
                    </div>

                    {{-- Jam Operasional --}}
                    <div class="flex items-start gap-4 bg-white/60 rounded-xl border-t-4 border-sage p-6 shadow-sm">
                        <div class="w-11 h-11 shrink-0 rounded-lg bg-sage/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-sage" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                        </div>
                        <div class="w-full">
                            <h3 class="font-display text-lg font-semibold text-walnut mb-2">Jam Operasional</h3>
                            <div class="text-sm text-ink/65 space-y-1">
                                <div class="flex justify-between max-w-xs">
                                    <span>Senin – Minggu</span>
                                    <span>08.00 – 15.00</span>
                                </div>
                                <div class="flex justify-between max-w-xs">
                                    <span>Libur Nasional</span>
                                    <span class="text-ink/45">Tutup</span>
                                </div>
                            </div>
                            {{-- TODO: sesuaikan jam operasional sebenarnya --}}
                        </div>
                    </div>

                </div>

                {{-- Kolom kanan: peta lokasi --}}
                <div class="rounded-xl overflow-hidden shadow-sm border-t-4 border-rust h-full min-h-[420px]">
                    {{--
                        TODO: ganti src di bawah dengan embed link asli dari Google Maps.
                        Caranya: buka Google Maps → cari lokasi workshop → Share → Embed a map → Copy HTML → ambil isi src="...".
                    --}}
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.2668755922928!2d112.21557659999999!3d-7.5458486!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e784100388ec085%3A0x8c8046a0b52530b9!2sTOKO%20BRANKAS%20ADIJAYA!5e0!3m2!1sid!2sid!4v1784735211292!5m2!1sid!2sid"
                         class="w-full h-full min-h-[420px] border-0" allowfullscreen="" loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin" title="Lokasi Brankas Murah Jombang"></iframe>
                    {{-- <iframe src="https://www.google.com/maps?q=Jombang,Jawa+Timur&output=embed"
                        class="w-full h-full min-h-[420px] border-0" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" title="Lokasi Naima Furniture di Jombang">
                    </iframe> --}}
                </div>

            </div>
        </div>
    </section>

    {{-- ============ CTA ============ --}}
    <section class="bg-walnut-dark">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 py-16 text-center">
            <h2 class="font-display text-2xl sm:text-3xl font-semibold text-canvas mb-4">
                Lebih cepat lewat WhatsApp
            </h2>
            <p class="text-canvas/70 mb-8 max-w-xl mx-auto">
                Chat langsung dengan tim kami untuk konsultasi produk atau cek status pesanan.
            </p>
            <a href="https://wa.me/{{ config('shop.whatsapp_number', '6281200000000') }}" target="_blank" rel="noopener"
                class="inline-flex items-center px-6 py-3 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
                Chat via WhatsApp
            </a>
        </div>
    </section>
@endsection
