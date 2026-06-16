@props(['as' => 'div'])

<{{ $as }} {{ $attributes->merge(['class' => 'flex w-fit max-w-full items-baseline gap-2 font-mono text-xs uppercase tracking-[0.2em] text-ink-soft']) }}>
    <span aria-hidden="true" class="text-teal">//</span>
    <span class="min-w-0">{{ $slot }}</span>
</{{ $as }}>
