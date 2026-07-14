@extends('layouts.admin')

@section('title', 'Produk')
@section('page-title', 'Produk')

@section('content')
<div class="flex items-center justify-between gap-4 mb-6">
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-3 flex-1 max-w-xl">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..."
            class="flex-1 rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        <select name="category_id" class="rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 rounded-lg bg-walnut/10 text-walnut text-sm font-medium hover:bg-walnut/15 transition-colors">
            Cari
        </button>
    </form>

    <a href="{{ route('admin.products.create') }}"
        class="px-4 py-2.5 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors whitespace-nowrap">
        + Tambah Produk
    </a>
</div>

<div class="bg-white/60 rounded-xl border border-walnut/10 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-walnut/10 text-left text-xs uppercase tracking-wide text-ink/50">
                <th class="px-6 py-3 font-medium">Produk</th>
                <th class="px-6 py-3 font-medium">Kategori</th>
                <th class="px-6 py-3 font-medium">Harga</th>
                <th class="px-6 py-3 font-medium">Stok</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-walnut/10">
            @forelse ($products as $product)
                <tr class="hover:bg-canvas/60 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if ($product->primaryImage->first())
                                <img src="{{ Storage::url($product->primaryImage->first()->image_path) }}" alt="{{ $product->name }}"
                                    class="w-10 h-10 rounded-lg object-cover border border-walnut/10">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-walnut/5 flex items-center justify-center text-walnut/30 text-xs">—</div>
                            @endif
                            <div>
                                <span class="text-walnut font-medium block">{{ $product->name }}</span>
                                @if ($product->sku)
                                    <span class="text-xs text-ink/40">{{ $product->sku }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-ink/60">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-ink/70">
                        @if ($product->sale_price)
                            <span class="line-through text-ink/40 text-xs">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="block text-rust font-medium">Rp{{ number_format($product->sale_price, 0, ',', '.') }}</span>
                        @else
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="px-6 py-4 text-ink/60">{{ $product->stock }}</td>
                    <td class="px-6 py-4">
                        @if ($product->is_active)
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-sage/10 text-sage">Aktif</span>
                        @else
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-walnut/10 text-walnut/60">Nonaktif</span>
                        @endif
                        @if ($product->is_featured)
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-brass/10 text-brass ml-1">Unggulan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('admin.products.edit', $product) }}"
                            class="text-rust text-sm font-medium hover:underline">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus produk {{ $product->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rust/70 text-sm font-medium hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-ink/50">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($products->hasPages())
    <div class="mt-6">
        {{ $products->appends(request()->query())->links() }}
    </div>
@endif
@endsection