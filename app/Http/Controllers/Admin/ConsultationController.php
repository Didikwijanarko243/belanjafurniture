<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Order;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with('items', 'order')
            ->latest()
            ->paginate(20);

        return view('admin.consultations.index', compact('consultations'));
    }

    public function show(Consultation $consultation)
    {
        $consultation->load('items', 'order');

        return view('admin.consultations.show', compact('consultation'));
    }

    public function updateStatus(Request $request, Consultation $consultation)
    {
        $request->validate([
            'status'      => 'required|in:baru,dihubungi,deal,batal',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $consultation->update($request->only('status', 'admin_notes'));

        return back()->with('success', 'Status konsultasi diperbarui.');
    }

    public function showConvertForm(Consultation $consultation)
    {
        if ($consultation->order()->exists()) {
            return redirect()
                ->route('admin.orders.show', $consultation->order)
                ->with('error', 'Konsultasi ini sudah punya order.');
        }

        $consultation->load('items');

        return view('admin.consultations.convert', compact('consultation'));
    }

    public function convertToOrder(Request $request, Consultation $consultation)
    {
        if ($consultation->order()->exists()) {
            return back()->with('error', 'Konsultasi ini sudah punya order.');
        }

        $validated = $request->validate([
            'customer_name'    => 'required|string|max:100',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
        ]);

        $totalPrice = $consultation->items->sum(fn ($item) => $item->price * $item->quantity);

        $order = Order::create([
            'order_number'      => Order::generateOrderNumber(),
            'consultation_id'   => $consultation->id,
            'session_id'        => $consultation->session_id,
            'customer_name'     => $validated['customer_name'],
            'customer_phone'    => $validated['customer_phone'],
            'customer_address'  => $validated['customer_address'],
            'status'            => 'pending',
            'total_price'       => $totalPrice,
        ]);

        foreach ($consultation->items as $item) {
            $order->items()->create([
                'product_id'         => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'product_name'       => $item->product_name,
                'variant_name'       => $item->variant_name,
                'quantity'           => $item->quantity,
                'price'              => $item->price,
            ]);
        }

        $consultation->update(['status' => 'deal']);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', "Order {$order->order_number} berhasil dibuat.");
    }
}