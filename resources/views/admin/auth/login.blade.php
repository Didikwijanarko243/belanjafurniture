<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas text-ink font-body antialiased min-h-screen flex items-center justify-center px-6">

    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <span class="font-display text-2xl font-semibold text-walnut">Naima</span>
            <p class="text-xs text-ink/50 uppercase tracking-[0.15em] mt-1">Admin Panel</p>
        </div>

        <div class="bg-white/60 rounded-xl border-t-4 border-rust shadow-sm p-8">
            @if ($errors->any())
                <div class="mb-5 px-4 py-3 rounded-lg bg-rust/10 border border-rust/20 text-sm text-rust">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-walnut mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" autofocus
                        class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-walnut mb-1.5">Kata Sandi</label>
                    <input type="password" name="password"
                        class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
                </div>

                <button type="submit"
                    class="w-full px-6 py-3 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors mt-2">
                    Masuk
                </button>
            </form>
        </div>
    </div>

</body>
</html>