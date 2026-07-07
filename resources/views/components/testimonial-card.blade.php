@props(['name', 'role' => null, 'comment', 'rating' => 5])

<div {{ $attributes->merge(['class' => 'bg-white/50 border border-walnut/10 rounded-xl p-6']) }}>
    <div class="text-brass mb-3" aria-label="{{ $rating }} dari 5 bintang">
        @for($i = 1; $i <= 5; $i++)
            {{ $i <= $rating ? '★' : '☆' }}
        @endfor
    </div>

    <p class="text-ink/70 leading-relaxed mb-5">
        &ldquo;{{ $comment }}&rdquo;
    </p>

    <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-walnut/15 flex items-center justify-center text-walnut font-semibold text-sm">
            {{ strtoupper(substr($name, 0, 1)) }}
        </div>
        <div>
            <p class="font-semibold text-ink text-sm">{{ $name }}</p>
            @if($role)
                <p class="text-ink/50 text-xs">{{ $role }}</p>
            @endif
        </div>
    </div>
</div>
