<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')
            ->parentOnly()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::parentOnly()->orderBy('name')->get();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateCategory($request);

        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('categories/og', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        $parents = Category::parentOnly()
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $this->validateCategory($request, $category->id);

        if ($validated['name'] !== $category->name) {
            $validated['slug'] = $this->uniqueSlug($validated['name'], $category->id);
        }

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        if ($request->hasFile('og_image')) {
            if ($category->og_image) {
                Storage::disk('public')->delete($category->og_image);
            }
            $validated['og_image'] = $request->file('og_image')->store('categories/og', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->children()->exists()) {
            return back()->with('error', 'Tidak bisa hapus kategori yang masih punya sub-kategori. Hapus atau pindahkan sub-kategorinya dulu.');
        }

        if ($category->products()->exists()) {
            return back()->with('error', 'Tidak bisa hapus kategori yang masih punya produk. Pindahkan produknya dulu.');
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        if ($category->og_image) {
            Storage::disk('public')->delete($category->og_image);
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    private function validateCategory(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'parent_id'         => ['nullable', 'exists:categories,id', $ignoreId ? "not_in:{$ignoreId}" : ''],
            'name'              => 'required|string|max:150',
            'description'       => 'nullable|string|max:1000',
            'image'             => 'nullable|image|max:2048',
            'sort_order'        => 'nullable|integer|min:0',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'canonical_url'     => 'nullable|url|max:255',
            'og_image'          => 'nullable|image|max:2048',
        ]);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}