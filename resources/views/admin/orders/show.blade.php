@extends('layouts.admin')

@section('title', 'Detail Order')
@section('page-title', $order->order_number)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kolom kiri: produk & data pelanggan --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white/60 rounded-xl border-t-4 border-sage p-6">
            <h2 class="font-display text-base font-semibold text-walnut mb-4">Produk Dipesan</h2>
            <ul class="divide-y divide-walnut/10 mb-4">
                @foreach ($order->items as $item)
                    <li class="py-3 flex justify-between text-sm">
                        <span class="text-walnut">
                            {{ $item->product_name }}{{ $item->variant_name ? " ({$item->variant_name})" : '' }}
                            <span class="text-ink/50">x{{ $item->quantity }}</span>
                        </span>
                        <span class="text-ink/70">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="flex justify-between font-semibold text-walnut pt-3 border-t border-walnut/10">
                <span>Total</span>
                <span>Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="bg-white/60 rounded-xl border-t-4 border-brass p-6">
            <h2 class="font-display text-base font-semibold text-walnut mb-4">Data Pelanggan</h2>
            <dl class="space-y-3 text-sm">
                <div class="flex gap-3">
                    <dt class="w-24 shrink-0 text-ink/50">Nama</dt>
                    <dd class="text-walnut">{{ $order->customer_name }}</dd>
                </div>
                <div class="flex gap-3">
                    <dt class="w-24 shrink-0 text-ink/50">No. HP</dt>
                    <dd class="text-walnut">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" target="_blank" class="text-rust hover:underline">
                            {{ $order->customer_phone }}
                        </a>
                    </dd>
                </div>
                <div class="flex gap-3">
                    <dt class="w-24 shrink-0 text-ink/50">Alamat</dt>
                    <dd class="text-walnut">{{ $order->customer_address }}</dd>
                </div>
            </dl>
        </div>

        @if ($order->consultation)
            <div class="bg-white/60 rounded-xl border border-walnut/10 p-6">
                <p class="text-sm text-ink/60">
                    Dibuat dari
                    <a href="{{ route('admin.consultations.show', $order->consultation) }}" class="text-rust font-medium hover:underline">
                        Konsultasi #{{ $order->consultation->id }}
                    </a>
                </p>
            </div>
        @endif
    </div>

    {{-- Kolom kanan: update status --}}
    <div>
        <div class="bg-white/60 rounded-xl border border-walnut/10 p-6">
            <h2 class="font-display text-base font-semibold text-walnut mb-4">Update Order</h2>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-walnut mb-1.5">Status</label>
                    <select name="status" class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
                        @foreach (['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'] as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-walnut mb-1.5">Total Harga</label>
                    <input type="number" step="0.01" name="total_price" value="{{ $order->total_price }}"
                        class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-walnut mb-1.5">Catatan</label>
                    <textarea name="notes" rows="3"
                        class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">{{ $order->notes }}</textarea>
                </div>

                <button type="submit"
                    class="w-full px-4 py-2.5 rounded-lg bg-walnut text-canvas text-sm font-semibold hover:bg-walnut/90 transition-colors">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

</div>
@endsection