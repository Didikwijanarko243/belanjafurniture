@props(['eyebrow' => null, 'title', 'subtitle' => null, 'align' => 'left'])

@php
    $alignClass = $align === 'center' ? 'text-center mx-auto' : 'text-left';
@endphp

<div {{ $attributes->merge(['class' => "mb-10 max-w-2xl $alignClass"]) }}>
    @if($eyebrow)
        <span class="inline-block text-sm font-medium text-rust tracking-wide uppercase mb-2">
            {{ $eyebrow }}
        </span>
    @endif

    <h2 class="font-display text-3xl text-ink mb-2">{{ $title }}</h2>

    @if($subtitle)
        <p class="text-ink/60">{{ $subtitle }}</p>
    @endif
</div>
