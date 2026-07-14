@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-10">
    <h1 class="text-xl font-semibold text-walnut mb-6">
        Jadikan Order — Konsultasi #{{ $consultation->id }}
    </h1>

    <div class="bg-white/60 rounded-xl border-t-4 border-sage p-6 mb-6">
        <h2 class="font-semibold text-sm text-walnut mb-3">Produk yang dikonsultasikan</h2>
        <ul class="divide-y divide-walnut/10">
            @foreach ($consultation->items as $item)
                <li class="py-2 flex justify-between text-sm">
                    <span>{{ $item->product_name }}{{ $item->variant_name ? " ({$item->variant_name})" : '' }} x{{ $item->quantity }}</span>
                    <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <form action="{{ route('admin.consultations.convert', $consultation) }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-walnut mb-1">Nama Pelanggan</label>
            <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            @error('customer_name') <p class="text-xs text-rust mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-walnut mb-1">No. HP / WhatsApp</label>
            <input type="text" name="customer_phone" value="{{ old('customer_phone') }}"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">
            @error('customer_phone') <p class="text-xs text-rust mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-walnut mb-1">Alamat Pengiriman</label>
            <textarea name="customer_address" rows="3"
                class="w-full rounded-lg border-walnut/20 focus:border-rust focus:ring-rust/20 text-sm">{{ old('customer_address') }}</textarea>
            @error('customer_address') <p class="text-xs text-rust mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
            class="px-6 py-3 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
            Buat Order
        </button>
    </form>
</div>
@endsection