{{-- resources/views/pesanan/partials/status-timeline.blade.php --}}
@php
    $steps = [
        'pending' => 'Menunggu Konfirmasi',
        'Diproses' => 'Diproses',
        'dikirim' => 'Dikirim',
        'selesai' => 'Selesai',
    ];
    $statusKeys = array_keys($steps);
    $currentIndex = array_search($order->status, $statusKeys);
    $isCancelled = $order->status === 'cancelled';
@endphp

@if ($isCancelled)
    <div class="rounded-lg bg-rust/10 text-rust px-4 py-3 text-sm font-medium">
        Pesanan ini dibatalkan.
        @if ($order->admin_note)
            <span class="block text-rust/70 font-normal mt-1">{{ $order->admin_note }}</span>
        @endif
    </div>
@else
    <div class="flex items-center justify-between">
        @foreach ($steps as $key => $label)
            @php
                $stepIndex = array_search($key, $statusKeys);
                $isDone = $stepIndex <= $currentIndex;
                $isCurrent = $stepIndex === $currentIndex;
            @endphp
            <div class="flex-1 flex flex-col items-center text-center relative">
                @if (!$loop->first)
                    <div class="absolute top-3 right-1/2 w-full h-0.5 {{ $isDone ? 'bg-rust' : 'bg-walnut/10' }}"></div>
                @endif
                <div class="relative z-10 w-6 h-6 rounded-full flex items-center justify-center text-xs font-semibold
                    {{ $isDone ? 'bg-rust text-canvas' : 'bg-walnut/10 text-walnut/40' }}
                    {{ $isCurrent ? 'ring-4 ring-rust/20' : '' }}">
                    @if ($isDone && !$isCurrent)
                        ✓
                    @else
                        {{ $loop->iteration }}
                    @endif
                </div>
                <span class="mt-2 text-xs {{ $isDone ? 'text-walnut font-medium' : 'text-walnut/40' }}">
                    {{ $label }}
                </span>
            </div>
        @endforeach
    </div>
@endif