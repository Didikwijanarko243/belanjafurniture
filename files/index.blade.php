@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 lg:px-8 py-12">

    <h1 class="font-display text-3xl font-semibold text-ink mb-8">Keranjang Belanja</h1>

    @if(session('success'))
        <div class="mb-6 bg-sage/10 border border-sage/30 text-sage-dark text-sm px-4 py-3 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if($cart->items->isEmpty())
        <div class="flex flex-col items-center justify-center text-center py-24 border border-dashed border-walnut/20 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-walnut/30 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="9" cy="21" r="1"/>
                <circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            <h3 class="font-display text-lg text-ink mb-1">Keranjang kamu masih kosong</h3>
            <p class="text-sm text-ink/50 max-w-sm mb-4">Yuk mulai jelajahi koleksi furniture kami.</p>
            <a href="{{ route('produk.index') }}" class="text-sm text-walnut font-medium hover:text-walnut-dark transition-colors">
                Lihat semua produk &rarr;
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Daftar item --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                    <div class="flex gap-4 border border-walnut/10 rounded-lg p-4">
                        <div class="w-20 h-20 rounded-md overflow-hidden bg-canvas shrink-0">
                            @php $image = $item->product->images->first(); @endphp
                            @if($image)
                                <img src="{{ Storage::url($image->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="flex-1">
                            <a href="{{ route('produk.show', $item->product->slug) }}" class="font-display text-base font-medium text-ink hover:text-walnut transition-colors">
                                {{ $item->product->name }}
                            </a>
                            @if($item->variant)
                                <p class="text-xs text-ink/50 mt-0.5">
                                    {{ collect([$item->variant->color, $item->variant->size])->filter()->join(' / ') }}
                                </p>
                            @endif
                            <p class="text-sm font-semibold text-walnut-dark mt-1">
                                Rp{{ number_format($item->price, 0, ',', '.') }}
                            </p>

                            <div class="flex items-center gap-4 mt-3">
                                <form method="POST" action="{{ route('keranjang.update', $item) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input
                                        type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                        class="w-16 border border-walnut/20 rounded-md px-2 py-1 text-sm text-center"
                                    >
                                    <button type="submit" class="text-xs text-walnut hover:text-walnut-dark transition-colors">Update</button>
                                </form>

                                <form method="POST" action="{{ route('keranjang.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-rust hover:text-rust-dark transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>

                        <div class="text-sm font-semibold text-ink shrink-0">
                            Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Ringkasan --}}
            <div class="lg:col-span-1">
                <div class="border border-walnut/10 rounded-lg p-6 sticky top-28">
                    <h2 class="font-display text-lg font-semibold text-ink mb-4">Ringkasan</h2>
                    <div class="flex justify-between text-sm text-ink/70 mb-2">
                        <span>Subtotal</span>
                        <span>Rp{{ number_format($cart->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-xs text-ink/40 mb-6">Ongkos kirim dihitung setelah checkout.</p>
                    <a
                        href="https://wa.me/{{ config('shop.whatsapp_number') }}?text={{ urlencode('Halo, saya mau checkout pesanan di keranjang saya.') }}"
                        target="_blank" rel="noopener"
                        class="block text-center w-full bg-walnut-dark text-canvas font-medium text-sm py-3 rounded-md hover:bg-walnut transition-colors"
                    >
                        Checkout via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
