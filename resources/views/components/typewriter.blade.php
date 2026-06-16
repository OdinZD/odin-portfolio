@props([
    'phrases' => [],
    'speed' => 55,
    'pause' => 1600,
    'tag' => 'span',
])

@php
    $phrases = array_values((array) $phrases);
@endphp

<{{ $tag }}
    x-data="typewriter(@js($phrases), { speed: {{ (int) $speed }}, pause: {{ (int) $pause }} })"
    x-init="start()"
    {{ $attributes }}
>
    {{-- Full text for assistive tech / no-JS; the animated copy is hidden from them. --}}
    <span class="sr-only">{{ implode('. ', $phrases) }}</span>
    <span aria-hidden="true" x-text="output"></span><span aria-hidden="true" class="caret"></span>
</{{ $tag }}>
