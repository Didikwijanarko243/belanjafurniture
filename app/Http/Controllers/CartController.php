<?php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    /**
     * GET /keranjang
     */
    public function index(): View
    {
        $cart = $this->cartService->getCurrentCart();
        $cart->load(['items.product.images', 'items.variant']);

        return view('pages.cart.index', [
            'cart'  => $cart,
            'title' => 'Keranjang Belanja - ' . config('app.name'),
        ]);
    }

    /**
     * POST /keranjang/tambah
     * Dipanggil via fetch dari tombol "Tambah ke Keranjang".
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id'         => ['required', 'exists:products,id'],
            'product_variant_id' => ['nullable', 'exists:product_variants,id'],
            'quantity'           => ['required', 'integer', 'min:1'],
        ]);

        $this->cartService->addItem(
            $validated['product_id'],
            $validated['product_variant_id'] ?? null,
            $validated['quantity']
        );

        return response()->json([
            'success'   => true,
            'message'   => 'Produk ditambahkan ke keranjang.',
            'cartCount' => $this->cartService->getItemCount(),
        ]);
    }

    /**
     * PATCH /keranjang/{cartItem}
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $this->cartService->updateQuantity($cartItem, $validated['quantity']);

        return back()->with('success', 'Jumlah produk diperbarui.');
    }

    /**
     * DELETE /keranjang/{cartItem}
     */
    public function destroy(CartItem $cartItem): RedirectResponse
    {
        $this->cartService->removeItem($cartItem);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function sendToWhatsapp(CartService $cart, ConsultationService $consultationService)
    {
        $items = $cart->getItems();

        if ($items->isEmpty()) {
            return back()->with('error', 'Keranjang masih kosong.');
        }

        $consultation = $consultationService->createFromCart($cart);

        $pesan = "Halo, saya ingin konsultasi produk berikut:\n\n";

        foreach ($items as $item) {
            $namaProduk = $item->product->name ?? '-';
            $namaVarian = $item->variant->name ?? null;

            $pesan .= "- {$namaProduk}";
            $pesan .= $namaVarian ? " ({$namaVarian})" : '';
            $pesan .= " x{$item->quantity}\n";
        }

        $pesan .= "\nMohon info ketersediaan, harga, dan ongkos kirimnya. Terima kasih.";
        $pesan .= "\n\nRef: KONSUL-{$consultation->id}";

        $consultation->update(['whatsapp_message' => $pesan]);

        $waNumber = config('shop.whatsapp_number', '6281200000000');
        $waLink   = "https://wa.me/{$waNumber}?text=" . urlencode($pesan);

        return redirect()->away($waLink);
    }
}
