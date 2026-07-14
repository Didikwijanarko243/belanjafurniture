<?php

namespace App\Services;

use App\Models\Consultation;

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
}