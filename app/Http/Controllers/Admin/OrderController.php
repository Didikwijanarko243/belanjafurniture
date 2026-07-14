<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'consultation');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'      => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
            'total_price' => 'required|numeric|min:0',
            'notes'       => 'nullable|string|max:1000',
        ]);

        $order->update($request->only('status', 'total_price', 'notes'));

        return back()->with('success', 'Status order diperbarui.');
    }
}