<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category', 'primaryImage')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated         = $this->validateProduct($request);
        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated         = $this->applyBooleans($request, $validated);

        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $this->storeAsWebp($request->file('og_image'), 'products/og'); // ← diubah
        }

        DB::transaction(function () use ($request, $validated, &$product) {
            $product = Product::create($validated);
            $this->syncNewImages($request, $product);
            $this->syncNewVariants($request, $product);
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load('images', 'variants');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request);

        if ($validated['name'] !== $product->name) {
            $validated['slug'] = $this->uniqueSlug($validated['name'], $product->id);
        }

        $validated = $this->applyBooleans($request, $validated);

        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $this->storeAsWebp($request->file('og_image'), 'products/og'); // ← diubah
        }

        DB::transaction(function () use ($request, $validated, $product) {
            $product->update($validated);
            $this->syncExistingImages($request, $product);
            $this->syncNewImages($request, $product);
            $this->syncExistingVariants($request, $product);
            $this->syncNewVariants($request, $product);
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        foreach ($product->variants as $variant) {
            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
            }
        }

        if ($product->og_image) {
            Storage::disk('public')->delete($product->og_image);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'category_id'                          => 'required|exists:categories,id',
            'name'                                 => 'required|string|max:200',
            'sku'                                  => 'nullable|string|max:100',
            'description'                          => 'nullable|string',
            'short_description'                    => 'nullable|string|max:500',
            'price'                                => 'required|numeric|min:0',
            'sale_price'                           => 'nullable|numeric|min:0|lt:price',
            'stock'                                => 'required|integer|min:0',
            'weight'                               => 'nullable|numeric|min:0',
            'length'                               => 'nullable|numeric|min:0',
            'width'                                => 'nullable|numeric|min:0',
            'height'                               => 'nullable|numeric|min:0',
            'material'                             => 'nullable|string|max:150',
            'finishing'                            => 'nullable|string|max:150',
            'production_days'                      => 'nullable|integer|min:0',
            'meta_title'                           => 'nullable|string|max:255',
            'meta_description'                     => 'nullable|string|max:500',
            'canonical_url'                        => 'nullable|url|max:255',
            'og_title'                             => 'nullable|string|max:255',
            'og_description'                       => 'nullable|string|max:500',
            'og_image'                             => 'nullable|image|max:2048',
            'youtube_url'                          => ['nullable', 'url', 'max:255', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/i'],

            'images.*'                             => 'nullable|image|max:2048',
            'existing_images.*.sort_order'         => 'nullable|integer|min:0',

            'new_variants.*.sku'                   => 'nullable|string|max:100',
            'new_variants.*.color'                 => 'nullable|string|max:100',
            'new_variants.*.size'                  => 'nullable|string|max:100',
            'new_variants.*.additional_price'      => 'nullable|numeric',
            'new_variants.*.stock'                 => 'nullable|integer|min:0',
            'new_variants.*.image'                 => 'nullable|image|max:2048',

            'existing_variants.*.sku'              => 'nullable|string|max:100',
            'existing_variants.*.color'            => 'nullable|string|max:100',
            'existing_variants.*.size'             => 'nullable|string|max:100',
            'existing_variants.*.additional_price' => 'nullable|numeric',
            'existing_variants.*.stock'            => 'nullable|integer|min:0',
            'existing_variants.*.image'            => 'nullable|image|max:2048',
        ]);
    }

    private function applyBooleans(Request $request, array $validated): array
    {
        $validated['is_custom_order'] = $request->boolean('is_custom_order');
        $validated['is_featured']     = $request->boolean('is_featured');
        $validated['is_active']       = $request->boolean('is_active');

        return $validated;
    }

    private function syncNewImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $hasPrimary = $product->images()->where('is_primary', true)->exists();

        foreach ($request->file('images') as $index => $file) {
            $path = $this->storeAsWebp($file, 'products');

            $product->images()->create([
                'image_path' => $path,
                'alt_text'   => $product->name,
                'is_primary' => ! $hasPrimary && $index === 0,
                'sort_order' => $product->images()->count(),
            ]);
        }
    }

    private function syncExistingImages(Request $request, Product $product): void
    {
        $existing = $request->input('existing_images', []);

        foreach ($existing as $imageId => $data) {
            $image = ProductImage::where('product_id', $product->id)->find($imageId);

            if (! $image) {
                continue;
            }

            if (! empty($data['delete'])) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
                continue;
            }

            $image->update([
                'is_primary' => ! empty($data['is_primary']),
                'sort_order' => $data['sort_order'] ?? $image->sort_order,
            ]);
        }

        // Pastikan cuma satu gambar primary
        if ($product->images()->where('is_primary', true)->count() > 1) {
            $keepId = $product->images()->where('is_primary', true)->first()->id;
            $product->images()->where('id', '!=', $keepId)->update(['is_primary' => false]);
        }
    }

    private function syncNewVariants(Request $request, Product $product): void
    {
        foreach ($request->input('new_variants', []) as $index => $data) {
            if (empty($data['color']) && empty($data['size']) && empty($data['sku'])) {
                continue;
            }

            $imagePath = null;
            if ($request->hasFile("new_variants.{$index}.image")) {
                $imagePath = $this->storeAsWebp($request->file("new_variants.{$index}.image"), 'variants');
            }

            $product->variants()->create([
                'sku'              => $data['sku'] ?? null,
                'color'            => $data['color'] ?? null,
                'size'             => $data['size'] ?? null,
                'additional_price' => $data['additional_price'] ?? 0,
                'stock'            => $data['stock'] ?? 0,
                'image'            => $imagePath,
                'is_active'        => ! empty($data['is_active']),
            ]);
        }
    }

    private function syncExistingVariants(Request $request, Product $product): void
    {
        $existing = $request->input('existing_variants', []);

        foreach ($existing as $variantId => $data) {
            $variant = ProductVariant::where('product_id', $product->id)->find($variantId);

            if (! $variant) {
                continue;
            }

            if (! empty($data['delete'])) {
                if ($variant->image) {
                    Storage::disk('public')->delete($variant->image);
                }
                $variant->delete();
                continue;
            }

            $updateData = [
                'sku'              => $data['sku'] ?? null,
                'color'            => $data['color'] ?? null,
                'size'             => $data['size'] ?? null,
                'additional_price' => $data['additional_price'] ?? 0,
                'stock'            => $data['stock'] ?? 0,
                'is_active'        => ! empty($data['is_active']),
            ];

            if ($request->hasFile("existing_variants.{$variantId}.image")) {
                if ($variant->image) {
                    Storage::disk('public')->delete($variant->image);
                }
                $updateData['image'] = $this->storeAsWebp($request->file("existing_variants.{$variantId}.image"), 'variants');
            }

            $variant->update($updateData);
        }
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (
            Product::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    private function storeAsWebp(UploadedFile $file, string $folder, string $disk = 'public'): string
    {
        $source = match ($file->getMimeType()) {
            'image/jpeg' => imagecreatefromjpeg($file->getRealPath()),
            'image/png'  => imagecreatefrompng($file->getRealPath()),
            'image/gif'  => imagecreatefromgif($file->getRealPath()),
            'image/webp' => imagecreatefromwebp($file->getRealPath()),
            default      => null,
        };

        // Fallback: kalau format tidak dikenali GD, simpan apa adanya
        if (! $source) {
            return $file->store($folder, $disk);
        }

        // Jaga transparansi PNG/GIF
        imagepalettetotruecolor($source);
        imagealphablending($source, true);
        imagesavealpha($source, true);

        $filename     = Str::random(40) . '.webp';
        $relativePath = "{$folder}/{$filename}";
        $fullPath     = Storage::disk($disk)->path($relativePath);

        if (! is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        imagewebp($source, $fullPath, 82); // 82 = kualitas, cukup tajam & hemat ukuran
        imagedestroy($source);

        return $relativePath;
    }
}
