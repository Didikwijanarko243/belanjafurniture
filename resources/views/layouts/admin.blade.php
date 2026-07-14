<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas text-ink font-body antialiased">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 shrink-0 bg-walnut-dark text-canvas flex flex-col">
            <div class="px-6 py-6 border-b border-canvas/10">
                <span class="font-display text-lg font-semibold tracking-tight">Naima</span>
                <span class="block text-xs text-canvas/50 uppercase tracking-[0.15em] mt-0.5">Admin Panel</span>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-1">
                <a href="{{ route('admin.consultations.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.consultations.*') ? 'bg-rust text-canvas' : 'text-canvas/70 hover:bg-canvas/5 hover:text-canvas' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    Konsultasi
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.orders.*') ? 'bg-rust text-canvas' : 'text-canvas/70 hover:bg-canvas/5 hover:text-canvas' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="7" width="18" height="14" rx="2" />
                        <path d="M8 7V5a4 4 0 0 1 8 0v2" />
                    </svg>
                    Order
                </a>
            </nav>

            <div class="px-3 py-4 border-t border-canvas/10">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-canvas/60 hover:bg-canvas/5 hover:text-canvas transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white/60 border-b border-walnut/10 px-8 py-5">
                <h1 class="font-display text-xl font-semibold text-walnut">@yield('page-title', 'Dashboard')</h1>
            </header>

            <main class="flex-1 px-8 py-8">
                @if (session('success'))
                    <div class="mb-6 px-4 py-3 rounded-lg bg-sage/10 border border-sage/20 text-sm text-sage-dark">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 px-4 py-3 rounded-lg bg-rust/10 border border-rust/20 text-sm text-rust">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>