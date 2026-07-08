@props(['rating' => 0, 'max' => 5, 'size' => 'w-4 h-4'])

@php
    $rating = max(0, min($max, (float) $rating));
@endphp

<div class="flex items-center gap-0.5" role="img" aria-label="Rating {{ $rating }} dari {{ $max }}">
    @for ($i = 1; $i <= $max; $i++)
        @php
            // Persentase terisi untuk bintang ke-$i: 0, 100, atau sebagian (misal 30%)
            $fill = max(0, min(1, $rating - ($i - 1))) * 100;
            $gradientId = 'star-fill-' . $i . '-' . str_replace('.', '', (string) $rating) . '-' . uniqid();
        @endphp
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }}">
            <defs>
                <linearGradient id="{{ $gradientId }}">
                    <stop offset="{{ $fill }}%" stop-color="var(--color-brass)"/>
                    <stop offset="{{ $fill }}%" stop-color="transparent"/>
                </linearGradient>
            </defs>
            <path
                d="M12 2.5l2.9 6.06 6.6.79-4.86 4.6 1.27 6.55L12 17.3l-5.91 3.2 1.27-6.55-4.86-4.6 6.6-.79L12 2.5z"
                fill="url(#{{ $gradientId }})"
                stroke="var(--color-brass)"
                stroke-width="1"
                stroke-linejoin="round"
            />
        </svg>
    @endfor
</div>
