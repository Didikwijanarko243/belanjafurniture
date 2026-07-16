<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Toko Furniture') }}</title>

    <meta name="description" content="{{ $metaDescription ?? 'Furniture kayu berkualitas untuk rumah Anda.' }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300..700;1,9..144,400..600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-canvas text-ink antialiased">

    {{-- ============ NAVBAR ============ --}}
    <header class="sticky top-0 z-50 bg-canvas/95 backdrop-blur border-b border-walnut/10">
        <nav class="max-w-7xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="font-display text-2xl font-semibold text-walnut tracking-tight">
                {{ config('app.name', 'Kayuna') }}
            </a>

            {{-- Nav links --}}
            <div class="hidden md:flex items-center gap-8 font-medium text-sm">
                <x-nav-link href="{{ url('/') }}" :active="request()->routeIs('home')">
                    Beranda
                </x-nav-link>
                <x-nav-link href="{{ route('produk.index') }}" :active="request()->routeIs('produk.*')">
                    Produk
                </x-nav-link>
                <x-mega-menu :categories="$navCategories ?? collect()" />
                <x-nav-link href="{{ url('/tentang') }}" :active="request()->routeIs('tentang')">
                    Tentang Kami
                </x-nav-link>
                <x-nav-link href="{{ url('/kontak') }}" :active="request()->routeIs('kontak')">
                    Kontak
                </x-nav-link>
            </div>

            {{-- Icons: search, wishlist, cart, akun --}}
            <div class="flex items-center gap-5">
                <button aria-label="Cari produk" class="text-ink/70 hover:text-walnut transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                </button>

                <a href="{{ url('/wishlist') }}" aria-label="Wishlist"
                    class="relative text-ink/70 hover:text-walnut transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                    </svg>
                    @if (($wishlistCount ?? 0) > 0)
                        <span id="wishlist-count-badge"
                            class="absolute -top-2 -right-2 w-4 h-4 flex items-center justify-center bg-rust text-canvas text-[10px] font-semibold rounded-full">
                            {{ $wishlistCount }}
                        </span>
                    @else
                        <span id="wishlist-count-badge"
                            class="hidden absolute -top-2 -right-2 w-4 h-4 items-center justify-center bg-rust text-canvas text-[10px] font-semibold rounded-full"></span>
                    @endif
                </a>

                <a href="{{ url('/keranjang') }}" aria-label="Keranjang belanja"
                    class="relative text-ink/70 hover:text-walnut transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                    @if (($cartCount ?? 0) > 0)
                        <span id="cart-count-badge"
                            class="absolute -top-2 -right-2 w-4 h-4 flex items-center justify-center bg-rust text-canvas text-[10px] font-semibold rounded-full">
                            {{ $cartCount }}
                        </span>
                    @else
                        <span id="cart-count-badge"
                            class="hidden absolute -top-2 -right-2 w-4 h-4 items-center justify-center bg-rust text-canvas text-[10px] font-semibold rounded-full"></span>
                    @endif
                </a>

                {{-- <a href="{{ url('/akun') }}"
                    class="hidden sm:inline-flex items-center gap-2 pl-5 border-l border-walnut/15 text-sm font-medium text-ink/70 hover:text-walnut transition-colors">
                    Akun
                </a> --}}

                <a href="{{ route('orders.track') }}"
                    class="flex items-center gap-1.5 text-sm text-walnut/70 hover:text-rust transition-colors"
                    title="Lacak Pesanan">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        <path d="M9 12h6M12 9v6" />
                    </svg>
                    <span class="hidden lg:inline">Lacak Pesanan</span>
                </a>
            </div>
        </nav>
    </header>

    {{-- ============ KONTEN ============ --}}
    <main>
        @yield('content')
    </main>

    {{-- Signature wood-grain divider sebelum footer --}}
    <div class="wood-divider"></div>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-walnut-dark text-canvas/90">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

            <div>
                <div class="font-display text-2xl font-semibold text-canvas mb-3">
                    {{ config('app.name', 'Kayuna') }}
                </div>
                <p class="text-sm text-canvas/60 leading-relaxed">
                    Furniture kayu solid, dibuat dengan tangan pengrajin lokal untuk rumah yang terasa hangat.
                </p>
            </div>

            <div>
                <h3 class="font-semibold text-sm text-brass mb-4 tracking-wide uppercase">Belanja</h3>
                <ul class="space-y-2 text-sm text-canvas/70">
                    <li><a href="{{ url('/produk') }}" class="hover:text-canvas transition-colors">Semua Produk</a>
                    </li>
                    <li><a href="{{ url('/kategori') }}" class="hover:text-canvas transition-colors">Kategori</a></li>
                    <li><a href="{{ url('/promo') }}" class="hover:text-canvas transition-colors">Promo</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold text-sm text-brass mb-4 tracking-wide uppercase">Bantuan</h3>
                <ul class="space-y-2 text-sm text-canvas/70">
                    <li><a href="{{ url('/cara-belanja') }}" class="hover:text-canvas transition-colors">Cara
                            Belanja</a></li>
                    <li><a href="{{ url('/pengiriman') }}" class="hover:text-canvas transition-colors">Pengiriman &
                            Retur</a></li>
                    <li><a href="{{ url('/faq') }}" class="hover:text-canvas transition-colors">FAQ</a></li>
                    <li>
                        <a href="{{ route('orders.track') }}"
                            class="text-canvas/70 hover:text-canvas text-sm transition-colors">
                            Lacak Pesanan
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold text-sm text-brass mb-4 tracking-wide uppercase">Hubungi Kami</h3>
                <ul class="space-y-2 text-sm text-canvas/70">
                    <li>WhatsApp: {{ config('shop.whatsapp_display', '+62 812-0000-0000') }}</li>
                    <li>Email: {{ config('shop.email', 'halo@kayuna.id') }}</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-canvas/10 py-6 text-center text-xs text-canvas/50">
            &copy; {{ date('Y') }} {{ config('app.name', 'Kayuna') }}. Semua hak dilindungi.
        </div>
    </footer>

</body>

</html>
