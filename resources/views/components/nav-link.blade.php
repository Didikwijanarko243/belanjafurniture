@props(['href', 'active' => false])

@php
    $classes = $active
        ? 'text-rust font-semibold'
        : 'text-ink/70 hover:text-walnut transition-colors';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "relative py-2 $classes"]) }}>
    {{ $slot }}
    @if ($active)
        <span class="absolute -bottom-px left-0 right-0 h-0.5 bg-rust rounded-full"></span>
    @endif
</a>
