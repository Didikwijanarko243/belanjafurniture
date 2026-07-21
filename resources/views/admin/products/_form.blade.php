@php
    $product = $product ?? null;
@endphp

{{-- Informasi Dasar --}}
<div class="bg-white/60 rounded-xl border border-walnut/10 p-6 space-y-4">
    <h2 class="font-display text-base font-semibold text-walnut mb-2">Informasi Dasar</h2>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Kategori</label>
        <select name="category_id" class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            <option value="">— Pilih kategori —</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $product?->category_id) == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('category_id') <p class="text-xs text-rust mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name', $product?->name) }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            @error('name') <p class="text-xs text-rust mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $product?->sku) }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Deskripsi Singkat</label>
        <input type="text" name="short_description" value="{{ old('short_description', $product?->short_description) }}"
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Deskripsi Lengkap</label>
        <textarea name="description" rows="5"
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">{{ old('description', $product?->description) }}</textarea>
    </div>
</div>

{{-- Harga & Stok --}}
<div class="bg-white/60 rounded-xl border border-walnut/10 p-6 space-y-4">
    <h2 class="font-display text-base font-semibold text-walnut mb-2">Harga & Stok</h2>

    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">Harga Normal</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product?->price) }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            @error('price') <p class="text-xs text-rust mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">Harga Diskon</label>
            <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product?->sale_price) }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            @error('sale_price') <p class="text-xs text-rust mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">Stok</label>
            <input type="number" name="stock" value="{{ old('stock', $product?->stock) }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            @error('stock') <p class="text-xs text-rust mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</div>

{{-- Dimensi & Material --}}
<div class="bg-white/60 rounded-xl border border-walnut/10 p-6 space-y-4">
    <h2 class="font-display text-base font-semibold text-walnut mb-2">Dimensi & Material</h2>

    <div class="grid grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">Berat (kg)</label>
            <input type="number" step="0.01" name="weight" value="{{ old('weight', $product?->weight) }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">Panjang (cm)</label>
            <input type="number" step="0.01" name="length" value="{{ old('length', $product?->length) }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">Lebar (cm)</label>
            <input type="number" step="0.01" name="width" value="{{ old('width', $product?->width) }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">Tinggi (cm)</label>
            <input type="number" step="0.01" name="height" value="{{ old('height', $product?->height) }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">Material</label>
            <input type="text" name="material" value="{{ old('material', $product?->material) }}" placeholder="Kayu Jati, Mahoni, dll"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">Finishing</label>
            <input type="text" name="finishing" value="{{ old('finishing', $product?->finishing) }}" placeholder="Natural, Melamin, dll"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        </div>
    </div>
</div>

{{-- Custom Order & Status --}}
<div class="bg-white/60 rounded-xl border border-walnut/10 p-6 space-y-4">
    <h2 class="font-display text-base font-semibold text-walnut mb-2">Pengaturan</h2>

    <div class="flex items-center gap-2">
        <input type="checkbox" id="is_custom_order" name="is_custom_order" value="1"
            @checked(old('is_custom_order', $product?->is_custom_order))
            class="rounded border-walnut/20 text-rust focus:ring-rust/20">
        <label for="is_custom_order" class="text-sm font-medium text-walnut">Bisa custom order (pesan sesuai permintaan)</label>
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Estimasi Hari Produksi</label>
        <input type="number" name="production_days" value="{{ old('production_days', $product?->production_days) }}"
            class="w-full max-w-xs rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
    </div>

    <div class="flex items-center gap-6 pt-2">
        <div class="flex items-center gap-2">
            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                @checked(old('is_featured', $product?->is_featured))
                class="rounded border-walnut/20 text-rust focus:ring-rust/20">
            <label for="is_featured" class="text-sm font-medium text-walnut">Produk unggulan</label>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" id="is_active" name="is_active" value="1"
                @checked(old('is_active', $product?->is_active ?? true))
                class="rounded border-walnut/20 text-rust focus:ring-rust/20">
            <label for="is_active" class="text-sm font-medium text-walnut">Aktif & tampil di toko</label>
        </div>
    </div>
</div>

{{-- Gambar Produk --}}
<div class="bg-white/60 rounded-xl border-t-4 border-sage p-6 space-y-4">
    <h2 class="font-display text-base font-semibold text-walnut mb-2">Gambar Produk</h2>

    @if ($product?->images->count())
        <div class="grid grid-cols-4 gap-4 mb-4">
            @foreach ($product->images as $image)
                <div class="relative border border-walnut/10 rounded-lg p-3 space-y-2">
                    <img src="{{ Storage::url($image->image_path) }}" class="w-full h-24 object-cover rounded-lg">
                    <label class="flex items-center gap-1.5 text-xs text-walnut">
                        <input type="radio" name="primary_image_marker" onclick="document.getElementById('primary_{{ $image->id }}').checked = true"
                            @checked($image->is_primary)>
                        Utama
                    </label>
                    <input type="hidden" id="primary_{{ $image->id }}" name="existing_images[{{ $image->id }}][is_primary]" value="{{ $image->is_primary ? 1 : 0 }}">
                    <script>
                        document.currentScript.previousElementSibling.previousElementSibling
                            .querySelector('input[type=radio]').addEventListener('change', function () {
                                document.getElementById('primary_{{ $image->id }}').value = this.checked ? 1 : 0;
                            });
                    </script>
                    <label class="flex items-center gap-1.5 text-xs text-rust">
                        <input type="checkbox" name="existing_images[{{ $image->id }}][delete]" value="1">
                        Hapus
                    </label>
                </div>
            @endforeach
        </div>
    @endif

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Tambah Gambar Baru</label>
        <input type="file" name="images[]" accept="image/*" multiple
            class="w-full text-sm text-ink/70 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-walnut/5 file:text-walnut file:text-sm file:font-medium">
        <p class="text-xs text-ink/50 mt-1">Gambar pertama otomatis jadi gambar utama kalau belum ada gambar utama.</p>
    </div>
</div>

{{-- Video YouTube --}}
<div class="bg-white/60 rounded-xl border border-walnut/10 p-6 space-y-4">
    <h2 class="font-display text-base font-semibold text-walnut mb-2">Video YouTube</h2>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Link Video YouTube</label>
        <input type="url" name="youtube_url" value="{{ old('youtube_url', $product?->youtube_url) }}"
            placeholder="https://www.youtube.com/watch?v=..."
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        @error('youtube_url') <p class="text-xs text-rust mt-1">{{ $message }}</p> @enderror
        <p class="text-xs text-ink/50 mt-1">Opsional. Video akan tampil di halaman detail produk.</p>
    </div>

    @if ($product?->youtube_embed_url)
        <div class="aspect-video rounded-lg overflow-hidden border border-walnut/10">
            <iframe src="{{ $product->youtube_embed_url }}" class="w-full h-full" allowfullscreen></iframe>
        </div>
    @endif
</div>

{{-- Varian Produk --}}
<div class="bg-white/60 rounded-xl border-t-4 border-brass p-6 space-y-4">
    <div class="flex items-center justify-between mb-2">
        <h2 class="font-display text-base font-semibold text-walnut">Varian Produk</h2>
        <button type="button" id="add-variant-btn"
            class="px-3 py-1.5 rounded-lg bg-walnut/10 text-walnut text-xs font-semibold hover:bg-walnut/15 transition-colors">
            + Tambah Varian
        </button>
    </div>

    <div id="variants-container" class="space-y-4">
        @if ($product?->variants->count())
            @foreach ($product->variants as $variant)
                <div class="border border-walnut/10 rounded-lg p-4 grid grid-cols-6 gap-3 items-end">
                    <div>
                        <label class="block text-xs font-medium text-walnut mb-1">SKU</label>
                        <input type="text" name="existing_variants[{{ $variant->id }}][sku]" value="{{ $variant->sku }}"
                            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-walnut mb-1">Warna</label>
                        <input type="text" name="existing_variants[{{ $variant->id }}][color]" value="{{ $variant->color }}"
                            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-walnut mb-1">Ukuran</label>
                        <input type="text" name="existing_variants[{{ $variant->id }}][size]" value="{{ $variant->size }}"
                            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-walnut mb-1">Tambahan Harga</label>
                        <input type="number" step="0.01" name="existing_variants[{{ $variant->id }}][additional_price]" value="{{ $variant->additional_price }}"
                            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-walnut mb-1">Stok</label>
                        <input type="number" name="existing_variants[{{ $variant->id }}][stock]" value="{{ $variant->stock }}"
                            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="flex items-center gap-1.5 text-xs text-walnut">
                            <input type="checkbox" name="existing_variants[{{ $variant->id }}][is_active]" value="1" @checked($variant->is_active)>
                            Aktif
                        </label>
                        <label class="flex items-center gap-1.5 text-xs text-rust ml-auto">
                            <input type="checkbox" name="existing_variants[{{ $variant->id }}][delete]" value="1">
                            Hapus
                        </label>
                    </div>
                    <div class="col-span-6">
                        <label class="block text-xs font-medium text-walnut mb-1">Gambar Varian (opsional)</label>
                        @if ($variant->image)
                            <img src="{{ Storage::url($variant->image) }}" class="w-12 h-12 rounded-lg object-cover border border-walnut/10 mb-1 inline-block">
                        @endif
                        <input type="file" name="existing_variants[{{ $variant->id }}][image]" accept="image/*"
                            class="block w-full text-sm text-ink/70 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-walnut/5 file:text-walnut file:text-xs file:font-medium">
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <template id="variant-template">
        <div class="border border-walnut/10 rounded-lg p-4 grid grid-cols-6 gap-3 items-end variant-row">
            <div>
                <label class="block text-xs font-medium text-walnut mb-1">SKU</label>
                <input type="text" name="new_variants[__INDEX__][sku]" class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-walnut mb-1">Warna</label>
                <input type="text" name="new_variants[__INDEX__][color]" class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-walnut mb-1">Ukuran</label>
                <input type="text" name="new_variants[__INDEX__][size]" class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-walnut mb-1">Tambahan Harga</label>
                <input type="number" step="0.01" name="new_variants[__INDEX__][additional_price]" value="0" class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-walnut mb-1">Stok</label>
                <input type="number" name="new_variants[__INDEX__][stock]" value="0" class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            </div>
            <div class="flex items-center gap-2">
                <label class="flex items-center gap-1.5 text-xs text-walnut">
                    <input type="checkbox" name="new_variants[__INDEX__][is_active]" value="1" checked>
                    Aktif
                </label>
                <button type="button" class="remove-variant-btn text-xs text-rust ml-auto">Batalkan</button>
            </div>
            <div class="col-span-6">
                <label class="block text-xs font-medium text-walnut mb-1">Gambar Varian (opsional)</label>
                <input type="file" name="new_variants[__INDEX__][image]" accept="image/*"
                    class="block w-full text-sm text-ink/70 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-walnut/5 file:text-walnut file:text-xs file:font-medium">
            </div>
        </div>
    </template>
</div>

{{-- SEO --}}
<div class="bg-white/60 rounded-xl border border-walnut/10 p-6 space-y-4">
    <h2 class="font-display text-base font-semibold text-walnut mb-2">SEO</h2>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Meta Title</label>
        <input type="text" name="meta_title" value="{{ old('meta_title', $product?->meta_title) }}"
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Meta Description</label>
        <textarea name="meta_description" rows="2"
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">{{ old('meta_description', $product?->meta_description) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">Canonical URL</label>
        <input type="url" name="canonical_url" value="{{ old('canonical_url', $product?->canonical_url) }}" placeholder="https://..."
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">OG Title</label>
            <input type="text" name="og_title" value="{{ old('og_title', $product?->og_title) }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-walnut mb-1.5">OG Image</label>
            @if ($product?->og_image)
                <img src="{{ Storage::url($product->og_image) }}" class="w-12 h-12 rounded-lg object-cover border border-walnut/10 mb-1">
            @endif
            <input type="file" name="og_image" accept="image/*"
                class="w-full text-sm text-ink/70 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-walnut/5 file:text-walnut file:text-sm file:font-medium">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-walnut mb-1.5">OG Description</label>
        <textarea name="og_description" rows="2"
            class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">{{ old('og_description', $product?->og_description) }}</textarea>
    </div>
</div>

<script>
(function () {
    const container = document.getElementById('variants-container');
    const template = document.getElementById('variant-template');
    const addBtn = document.getElementById('add-variant-btn');
    let newIndex = 0;

    addBtn.addEventListener('click', function () {
        const clone = template.content.cloneNode(true);
        clone.querySelectorAll('[name*="__INDEX__"]').forEach(el => {
            el.name = el.name.replace('__INDEX__', newIndex);
        });
        clone.querySelector('.remove-variant-btn').addEventListener('click', function (e) {
            e.target.closest('.variant-row').remove();
        });
        container.appendChild(clone);
        newIndex++;
    });
})();
</script>