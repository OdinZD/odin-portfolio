@props([
    'href' => null,
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $base = 'group inline-flex items-center justify-center gap-2 border border-ink font-mono font-bold tracking-tight whitespace-nowrap transition-all duration-150 disabled:cursor-not-allowed disabled:opacity-50';

    $variants = [
        'primary' => 'bg-amber text-ink shadow-[3px_3px_0_0_var(--color-ink)] hover:-translate-y-px hover:translate-x-px hover:shadow-[2px_2px_0_0_var(--color-ink)] active:translate-x-[3px] active:translate-y-[3px] active:shadow-none',
        'ink' => 'bg-ink text-paper shadow-[3px_3px_0_0_var(--color-amber)] hover:-translate-y-px hover:translate-x-px hover:shadow-[2px_2px_0_0_var(--color-amber)] active:translate-x-[3px] active:translate-y-[3px] active:shadow-none',
        'ghost' => 'bg-transparent text-ink hover:bg-ink hover:text-paper',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
