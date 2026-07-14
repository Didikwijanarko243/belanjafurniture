<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function form()
    {
        return view('pages.lacak-pesanan', [
            'title' => 'Lacak Pesanan — ' . config('app.name'),
        ]);
    }

    public function lookup(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::with('items')
            ->where('order_number', strtoupper(trim($request->order_number)))
            ->first();

        if (! $order) {
            return back()
                ->withInput()
                ->with('error', 'Nomor pesanan tidak ditemukan. Periksa kembali penulisannya.');
        }

        return view('pages.lacak-pesanan', [
            'title' => 'Lacak Pesanan — ' . config('app.name'),
            'order' => $order,
        ]);
    }
}