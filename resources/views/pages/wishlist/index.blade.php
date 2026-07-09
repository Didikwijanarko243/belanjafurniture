@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">

    <h1 class="font-display text-3xl font-semibold text-ink mb-8">Wishlist Saya</h1>

    @if($products->isEmpty())
        <div class="flex flex-col items-center justify-center text-center py-24 border border-dashed border-walnut/20 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-walnut/30 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
            <h3 class="font-display text-lg text-ink mb-1">Wishlist kamu masih kosong</h3>
            <p class="text-sm text-ink/50 max-w-sm mb-4">Tandai produk favoritmu dengan ikon hati saat menjelajah.</p>
            <a href="{{ route('produk.index') }}" class="text-sm text-walnut font-medium hover:text-walnut-dark transition-colors">
                Lihat semua produk &rarr;
            </a>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
            @foreach($products as $product)
                <x-product-card :product="$product" :in-wishlist="true" />
            @endforeach
        </div>
    @endif
</div>
@endsection
