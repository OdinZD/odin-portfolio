{{-- A small typewritten tech chip. --}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center border border-line bg-paper px-2 py-0.5 font-mono text-xs text-ink-soft']) }}>
    {{ $slot }}
</span>
