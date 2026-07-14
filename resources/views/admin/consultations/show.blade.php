@extends('layouts.admin')

@section('title', 'Detail Konsultasi')
@section('page-title', 'Konsultasi #' . $consultation->id)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kolom kiri: produk & pesan WA --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white/60 rounded-xl border-t-4 border-sage p-6">
            <h2 class="font-display text-base font-semibold text-walnut mb-4">Produk yang Dikonsultasikan</h2>
            <ul class="divide-y divide-walnut/10">
                @foreach ($consultation->items as $item)
                    <li class="py-3 flex justify-between text-sm">
                        <span class="text-walnut">
                            {{ $item->product_name }}{{ $item->variant_name ? " ({$item->variant_name})" : '' }}
                            <span class="text-ink/50">x{{ $item->quantity }}</span>
                        </span>
                        <span class="text-ink/70">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        @if ($consultation->whatsapp_message)
            <div class="bg-white/60 rounded-xl border-t-4 border-brass p-6">
                <h2 class="font-display text-base font-semibold text-walnut mb-3">Pesan WhatsApp Terkirim</h2>
                <pre class="text-xs text-ink/70 whitespace-pre-wrap font-body bg-canvas rounded-lg p-4">{{ $consultation->whatsapp_message }}</pre>
            </div>
        @endif

        @if ($consultation->order)
            <div class="bg-white/60 rounded-xl border-t-4 border-sage p-6">
                <h2 class="font-display text-base font-semibold text-walnut mb-2">Order Terkait</h2>
                <p class="text-sm text-ink/70">
                    Konsultasi ini sudah dijadikan order
                    <a href="{{ route('admin.orders.show', $consultation->order) }}" class="text-rust font-medium hover:underline">
                        {{ $consultation->order->order_number }}
                    </a>
                </p>
            </div>
        @endif
    </div>

    {{-- Kolom kanan: status & aksi --}}
    <div class="space-y-6">
        <div class="bg-white/60 rounded-xl border border-walnut/10 p-6">
            <h2 class="font-display text-base font-semibold text-walnut mb-4">Update Status</h2>
            <form action="{{ route('admin.consultations.update', $consultation) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-walnut mb-1.5">Status</label>
                    <select name="status" class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
                        @foreach (['baru', 'dihubungi', 'deal', 'batal'] as $status)
                            <option value="{{ $status }}" @selected($consultation->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-walnut mb-1.5">Catatan Admin</label>
                    <textarea name="admin_notes" rows="3"
                        class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">{{ $consultation->admin_notes }}</textarea>
                </div>

                <button type="submit"
                    class="w-full px-4 py-2.5 rounded-lg bg-walnut text-canvas text-sm font-semibold hover:bg-walnut/90 transition-colors">
                    Simpan Status
                </button>
            </form>
        </div>

        @if (! $consultation->order)
            <div class="bg-white/60 rounded-xl border-t-4 border-rust p-6">
                <h2 class="font-display text-base font-semibold text-walnut mb-2">Kesepakatan Tercapai?</h2>
                <p class="text-sm text-ink/60 mb-4">Jadikan konsultasi ini order resmi setelah customer setuju.</p>
                <a href="{{ route('admin.consultations.convert.form', $consultation) }}"
                    class="block text-center w-full px-4 py-2.5 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
                    Jadikan Order
                </a>
            </div>
        @endif
    </div>

</div>
@endsection