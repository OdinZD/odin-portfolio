@props([
    'status' => 'Shipped',
    'year' => null,
    'rotate' => '-5deg',
])

@php
    // Live work gets the teal stamp; everything archived gets rust.
    $isLive = strtolower($status) === 'live';
    $tone = $isLive ? 'text-teal border-teal' : 'text-rust border-rust';
    $shortYear = $year ? "'" . substr((string) $year, -2) : null;
@endphp

<span
    {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 border-2 px-2.5 py-1 font-mono text-[0.7rem] font-bold uppercase tracking-[0.15em] opacity-90 $tone"]) }}
    style="transform: rotate({{ $rotate }});"
>
    <span aria-hidden="true" class="text-[0.6rem]">{{ $isLive ? '●' : '✓' }}</span>
    {{ $status }}@if ($shortYear) <span class="opacity-70">{{ $shortYear }}</span>@endif
</span>
