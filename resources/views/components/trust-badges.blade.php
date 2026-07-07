@props(['items' => null])

@php
    $badges = $items ?? [
        ['icon' => 'shield', 'label' => 'Garansi Kualitas', 'desc' => 'Setiap produk diperiksa sebelum dikirim'],
        ['icon' => 'truck', 'label' => 'Pengiriman Aman', 'desc' => 'Dikemas khusus untuk barang besar'],
        ['icon' => 'credit-card', 'label' => 'Pembayaran Fleksibel', 'desc' => 'Transfer, cicilan, atau COD area tertentu'],
        ['icon' => 'message-circle', 'label' => 'Konsultasi Gratis', 'desc' => 'Tanya rekomendasi lewat WhatsApp'],
    ];

    $icons = [
        'shield' => '<path d="M12 2 4 5v6c0 5.5 3.5 10.7 8 12 4.5-1.3 8-6.5 8-12V5l-8-3z"/>',
        'truck' => '<path d="M10 17h4V5H2v12h3"/><path d="M20 17h2v-3.34a4 4 0 0 0-1.17-2.83L19 9h-5v8h1"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>',
        'credit-card' => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>',
        'message-circle' => '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'grid grid-cols-2 lg:grid-cols-4 gap-6']) }}>
    @foreach($badges as $badge)
        <div class="flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-rust shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                {!! $icons[$badge['icon']] !!}
            </svg>
            <div>
                <p class="font-semibold text-ink text-sm">{{ $badge['label'] }}</p>
                <p class="text-ink/50 text-xs mt-0.5">{{ $badge['desc'] }}</p>
            </div>
        </div>
    @endforeach
</div>
