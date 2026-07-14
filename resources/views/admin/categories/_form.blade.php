@php
    $category = $category ?? null;
@endphp

<div class="bg-white/60 rounded-xl border border-walnut/10 p-6 space-y-4">
    <h2 class="font-display text-base font-semibold text-walnut mb-2">Informasi Dasar</h2>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Kategori Induk</label>
        <select name="parent_id" class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            <option value="">Tidak ada (kategori utama)</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}" @selected(old('parent_id', $category?->parent_id) == $parent->id)>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Nama Kategori</label>
        <input type="text" name="name" value="{{ old('name', $category?->name) }}"
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        @error('name') <p class="text-xs text-rust mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Deskripsi</label>
        <textarea name="description" rows="3"
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">{{ old('description', $category?->description) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Gambar Kategori</label>
        @if ($category?->image)
            <img src="{{ Storage::url($category->image) }}" class="w-16 h-16 rounded-lg object-cover border border-walnut/10 mb-2">
        @endif
        <input type="file" name="image" accept="image/*"
            class="w-full text-sm text-ink/70 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-walnut/5 file:text-walnut file:text-sm file:font-medium">
        @error('image') <p class="text-xs text-rust mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">Urutan Tampil</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $category?->sort_order) }}" min="0"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        </div>

        <div class="flex items-center gap-2 pt-7">
            <input type="checkbox" id="is_active" name="is_active" value="1"
                @checked(old('is_active', $category?->is_active ?? true))
                class="rounded border-walnut/20 text-rust focus:ring-rust/20">
            <label for="is_active" class="text-sm font-medium text-walnut">Aktif & tampil di toko</label>
        </div>
    </div>
</div>

<div class="bg-white/60 rounded-xl border border-walnut/10 p-6 space-y-4">
    <h2 class="font-display text-base font-semibold text-walnut mb-2">SEO</h2>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Meta Title</label>
        <input type="text" name="meta_title" value="{{ old('meta_title', $category?->meta_title) }}"
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Meta Description</label>
        <textarea name="meta_description" rows="2"
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">{{ old('meta_description', $category?->meta_description) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Canonical URL</label>
        <input type="url" name="canonical_url" value="{{ old('canonical_url', $category?->canonical_url) }}"
            placeholder="https://..."
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">OG Image (untuk share media sosial)</label>
        @if ($category?->og_image)
            <img src="{{ Storage::url($category->og_image) }}" class="w-16 h-16 rounded-lg object-cover border border-walnut/10 mb-2">
        @endif
        <input type="file" name="og_image" accept="image/*"
            class="w-full text-sm text-ink/70 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-walnut/5 file:text-walnut file:text-sm file:font-medium">
    </div>
</div>