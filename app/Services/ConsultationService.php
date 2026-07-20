<?php
namespace App\Services;

use App\Models\Consultation;
use App\Models\Product;

class ConsultationService
{
    public function createFromCart(CartService $cart): Consultation
    {
        $items = $cart->getItems();

        $consultation = Consultation::create([
            'session_id' => $cart->getSessionId(),
            'status'     => 'baru',
        ]);

        foreach ($items as $item) {
            $consultation->items()->create([
                'product_id'         => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'product_name'       => $item->product->name ?? '-',
                'variant_name'       => $item->variant->name ?? null,
                'quantity'           => $item->quantity,
                'price'              => $item->price,
            ]);
        }

        return $consultation->load('items');
    }

    /**
     * Dipakai dari tombol WhatsApp di halaman detail produk (bukan dari keranjang).
     */
    public function createFromProduct(Product $product, CartService $cart, ?int $variantId, int $quantity): Consultation
    {
        $variant = $variantId
            ? $product->variants->firstWhere('id', $variantId)
            : null;

        $price = $product->final_price + ($variant->additional_price ?? 0);

        $variantName = $variant
            ? collect([$variant->color, $variant->size])->filter()->join(' / ')
            : null;

        $consultation = Consultation::create([
            'session_id' => $cart->getSessionId(),
            'status'     => 'baru',
        ]);

        $consultation->items()->create([
            'product_id'         => $product->id,
            'product_variant_id' => $variant->id ?? null,
            'product_name'       => $product->name,
            'variant_name'       => $variantName,
            'quantity'           => $quantity,
            'price'              => $price,
        ]);

        return $consultation->load('items');
    }
}
