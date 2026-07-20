<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;
use App\Services\ConsultationService;
use App\Services\ProdukService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(protected ProdukService $produkService)
    {
    }

    /**
     * Daftar semua produk, dengan filter lewat query string.
     * GET /produk
     */
    public function index(Request $request): View
    {
        $products = $this->produkService->getListing($request->only([
            'kategori', 'min', 'max', 'material', 'sort', 'q',
        ]));

        $categories = Category::active()->parentOnly()->orderBy('sort_order')->get();

        return view('pages.produk.index', [
            'products'        => $products,
            'categories'      => $categories,
            'title'           => 'Semua Produk - ' . config('app.name'),
            'metaDescription' => 'Jelajahi koleksi furniture kayu solid kami: sofa, meja, lemari, dan kursi berkualitas.',
        ]);
    }

    /**
     * Detail satu produk berdasarkan slug.
     * GET /produk/{product:slug}
     */
    public function show(Product $product): View
    {
        // Hanya hitung view untuk produk yang aktif, biar tidak dobel-log saat preview admin
        if ($product->is_active) {
            $product->increment('views_count');
        }

        $product->load(['images', 'variants' => fn($q) => $q->active(), 'approvedReviews']);

        $related = $this->produkService->getRelated($product);

        return view('pages.produk.show', [
            'product'         => $product,
            'related'         => $related,
            'title'           => $product->meta_title ?: $product->name . ' - ' . config('app.name'),
            'metaDescription' => $product->meta_description ?: $product->short_description,
        ]);
    }

    /**
     * Daftar produk berdasarkan kategori.
     * GET /kategori/{category:slug}
     */
    public function byCategory(Request $request, Category $category): View
    {
        $filters = array_merge(
            $request->only(['min', 'max', 'material', 'sort', 'q']),
            ['kategori' => $category->slug]
        );

        $products = $this->produkService->getListing($filters);

        $categories = Category::active()->parentOnly()->orderBy('sort_order')->get();

        return view('pages.produk.index', [
            'products'        => $products,
            'categories'      => $categories,
            'activeCategory'  => $category,
            'title'           => $category->meta_title ?: $category->name . ' - ' . config('app.name'),
            'metaDescription' => $category->meta_description ?: $category->description,
        ]);
    }

    private function getAvailableMaterials()
    {
        return Product::query()
            ->active()
            ->whereNotNull('material')
            ->distinct()
            ->orderBy('material')
            ->pluck('material');
    }

    public function sendToWhatsapp(
        Request $request,
        Product $produk,
        CartService $cartService,
        ConsultationService $consultationService
    ) {
        $validated = $request->validate([
            'product_variant_id' => ['nullable', 'exists:product_variants,id'],
            'quantity'           => ['required', 'integer', 'min:1'],
        ]);

        $variantId = $validated['product_variant_id'] ?? null;
        $quantity  = $validated['quantity'];

        // Cek stok sebelum bikin konsultasi
        if ($variantId) {
            $variant = $produk->variants->firstWhere('id', $variantId);
            if (! $variant || $variant->stock < $quantity) {
                return back()->with('error', 'Varian tidak tersedia atau stok tidak mencukupi.');
            }
        } elseif ($produk->stock < $quantity) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $consultation = $consultationService->createFromProduct($produk, $cartService, $variantId, $quantity);

        $pesan = "Halo, saya ingin konsultasi detail produk berikut:\n\n";

        foreach ($consultation->items as $item) {
            $pesan .= "- {$item->product_name}";
            $pesan .= $item->variant_name ? " ({$item->variant_name})" : '';
            $pesan .= " x{$item->quantity}\n";
        }

        $pesan .= "\nMohon info ketersediaan, harga, dan ongkos kirimnya. Terima kasih.";
        $pesan .= "\n\nRef: KONSUL-{$consultation->id}";

        $consultation->update(['whatsapp_message' => $pesan]);

        $waNumber  = config('shop.whatsapp_number', '6281200000000');
        $waLink    = "https://wa.me/{$waNumber}?text=" . urlencode($pesan);

        return redirect()->away($waLink);
    }

}
