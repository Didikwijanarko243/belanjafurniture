@extends('layouts.admin')

@section('title', 'Konsultasi')
@section('page-title', 'Konsultasi Masuk')

@section('content')
<div class="bg-white/60 rounded-xl border border-walnut/10 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-walnut/10 text-left text-xs uppercase tracking-wide text-ink/50">
                <th class="px-6 py-3 font-medium">ID</th>
                <th class="px-6 py-3 font-medium">Produk</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium">Masuk</th>
                <th class="px-6 py-3 font-medium text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-walnut/10">
            @forelse ($consultations as $consultation)
                <tr class="hover:bg-canvas/60 transition-colors">
                    <td class="px-6 py-4 font-mono text-xs text-ink/60">#{{ $consultation->id }}</td>
                    <td class="px-6 py-4 text-walnut">
                        {{ $consultation->items->count() }} produk
                        <span class="block text-xs text-ink/50">
                            {{ $consultation->items->pluck('product_name')->take(2)->join(', ') }}{{ $consultation->items->count() > 2 ? ', ...' : '' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $badgeMap = [
                                'baru' => 'bg-brass/10 text-brass',
                                'dihubungi' => 'bg-walnut/10 text-walnut',
                                'deal' => 'bg-sage/10 text-sage',
                                'batal' => 'bg-rust/10 text-rust',
                            ];
                        @endphp
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeMap[$consultation->status] ?? 'bg-walnut/10 text-walnut' }}">
                            {{ ucfirst($consultation->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-ink/60">{{ $consultation->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.consultations.show', $consultation) }}"
                            class="text-rust text-sm font-medium hover:underline">Lihat</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-ink/50">Belum ada konsultasi masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($consultations->hasPages())
    <div class="mt-6">
        {{ $consultations->links() }}
    </div>
@endif
@endsection