@extends('layouts.admin')

@section('title', 'Kategori')
@section('page-title', 'Kategori Produk')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.categories.create') }}"
        class="px-4 py-2.5 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
        + Tambah Kategori
    </a>
</div>

<div class="bg-white/60 rounded-xl border border-walnut/10 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-walnut/10 text-left text-xs uppercase tracking-wide text-ink/50">
                <th class="px-6 py-3 font-medium">Kategori</th>
                <th class="px-6 py-3 font-medium">Produk</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium">Urutan</th>
                <th class="px-6 py-3 font-medium text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-walnut/10">
            @forelse ($categories as $category)
                <tr class="hover:bg-canvas/60 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if ($category->image)
                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                    class="w-9 h-9 rounded-lg object-cover border border-walnut/10">
                            @else
                                <div class="w-9 h-9 rounded-lg bg-walnut/5 flex items-center justify-center text-walnut/30 text-xs">—</div>
                            @endif
                            <span class="text-walnut font-medium">{{ $category->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-ink/60">{{ $category->products()->count() }}</td>
                    <td class="px-6 py-4">
                        @if ($category->is_active)
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-sage/10 text-sage">Aktif</span>
                        @else
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-walnut/10 text-walnut/60">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-ink/60">{{ $category->sort_order ?? '-' }}</td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                            class="text-rust text-sm font-medium hover:underline">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus kategori {{ $category->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rust/70 text-sm font-medium hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>

                @foreach ($category->children as $child)
                    <tr class="hover:bg-canvas/60 transition-colors">
                        <td class="px-6 py-4 pl-14">
                            <div class="flex items-center gap-3">
                                @if ($child->image)
                                    <img src="{{ Storage::url($child->image) }}" alt="{{ $child->name }}"
                                        class="w-8 h-8 rounded-lg object-cover border border-walnut/10">
                                @else
                                    <div class="w-8 h-8 rounded-lg bg-walnut/5 flex items-center justify-center text-walnut/30 text-xs">—</div>
                                @endif
                                <span class="text-walnut/80 text-sm">{{ $child->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-ink/60">{{ $child->products()->count() }}</td>
                        <td class="px-6 py-4">
                            @if ($child->is_active)
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-sage/10 text-sage">Aktif</span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-walnut/10 text-walnut/60">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-ink/60">{{ $child->sort_order ?? '-' }}</td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('admin.categories.edit', $child) }}"
                                class="text-rust text-sm font-medium hover:underline">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $child) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin hapus kategori {{ $child->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rust/70 text-sm font-medium hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-ink/50">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection