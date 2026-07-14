@extends('layouts.admin')

@section('title', 'Order')
@section('page-title', 'Semua Order')

@section('content')
<div class="bg-white/60 rounded-xl border border-walnut/10 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-walnut/10 text-left text-xs uppercase tracking-wide text-ink/50">
                <th class="px-6 py-3 font-medium">No. Order</th>
                <th class="px-6 py-3 font-medium">Pelanggan</th>
                <th class="px-6 py-3 font-medium">Total</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium">Dibuat</th>
                <th class="px-6 py-3 font-medium text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-walnut/10">
            @forelse ($orders as $order)
                <tr class="hover:bg-canvas/60 transition-colors">
                    <td class="px-6 py-4 font-mono text-xs text-walnut">{{ $order->order_number }}</td>
                    <td class="px-6 py-4 text-walnut">
                        {{ $order->customer_name }}
                        <span class="block text-xs text-ink/50">{{ $order->customer_phone }}</span>
                    </td>
                    <td class="px-6 py-4 text-ink/70">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $badgeMap = [
                                'pending' => 'bg-brass/10 text-brass',
                                'diproses' => 'bg-walnut/10 text-walnut',
                                'dikirim' => 'bg-sage/10 text-sage',
                                'selesai' => 'bg-sage text-canvas',
                                'dibatalkan' => 'bg-rust/10 text-rust',
                            ];
                        @endphp
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeMap[$order->status] ?? 'bg-walnut/10 text-walnut' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-ink/60">{{ $order->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}"
                            class="text-rust text-sm font-medium hover:underline">Lihat</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-ink/50">Belum ada order.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($orders->hasPages())
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endif
@endsection