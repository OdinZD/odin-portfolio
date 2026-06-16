@php
    $links = [
        ['label' => 'Home', 'route' => 'home', 'active' => 'home'],
        ['label' => 'Projects', 'route' => 'projects.index', 'active' => 'projects.*'],
        ['label' => 'About', 'route' => 'about', 'active' => 'about'],
        ['label' => 'Contact', 'route' => 'contact', 'active' => 'contact'],
    ];
@endphp

<header
    x-data="{ open: false }"
    class="sticky top-0 z-40 border-b border-line/80 bg-paper/85 backdrop-blur-sm"
>
    <div class="mx-auto flex max-w-5xl items-center justify-between px-5 py-4 sm:px-8">
        {{-- Wordmark --}}
        <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 font-mono text-base font-bold tracking-tight">
            <span class="grid h-6 w-6 place-items-center bg-ink text-paper text-xs leading-none transition-colors group-hover:bg-amber group-hover:text-ink">
                OW
            </span>
            <span class="text-ink">odin<span class="text-amber-deep">wolf</span></span>
        </a>

        {{-- Desktop links --}}
        <nav class="hidden items-center gap-7 md:flex" aria-label="Primary">
            @foreach ($links as $link)
                @php $isActive = request()->routeIs($link['active']); @endphp
                <a
                    href="{{ route($link['route']) }}"
                    @class([
                        'relative font-mono text-sm tracking-tight transition-colors hover:text-ink',
                        'text-ink' => $isActive,
                        'text-ink-soft' => ! $isActive,
                    ])
                    @if ($isActive) aria-current="page" @endif
                >
                    @if ($isActive)<span aria-hidden="true" class="text-amber-deep">/</span>@endif{{ $link['label'] }}
                    @if ($isActive)
                        <span aria-hidden="true" class="absolute -bottom-1.5 left-0 h-0.5 w-full bg-amber"></span>
                    @endif
                </a>
            @endforeach
            <x-btn :href="route('contact')" variant="primary" size="sm">Start a project</x-btn>
        </nav>

        {{-- Mobile toggle --}}
        <button
            type="button"
            class="inline-flex items-center gap-2 font-mono text-sm md:hidden"
            x-on:click="open = ! open"
            :aria-expanded="open.toString()"
            aria-controls="mobile-menu"
        >
            <span x-text="open ? 'close' : 'menu'">menu</span>
            <span class="grid h-6 w-6 place-items-center border border-ink">
                <span x-show="!open" aria-hidden="true">+</span>
                <span x-show="open" aria-hidden="true" x-cloak>×</span>
            </span>
        </button>
    </div>

    {{-- Mobile menu --}}
    <nav
        id="mobile-menu"
        x-show="open"
        x-cloak
        x-transition.origin.top
        class="border-t border-line bg-card md:hidden"
        aria-label="Primary"
    >
        <ul class="mx-auto max-w-5xl divide-y divide-line/70 px-5 sm:px-8">
            @foreach ($links as $link)
                @php $isActive = request()->routeIs($link['active']); @endphp
                <li>
                    <a
                        href="{{ route($link['route']) }}"
                        x-on:click="open = false"
                        @class([
                            'flex items-center justify-between py-4 font-mono text-sm',
                            'text-amber-deep' => $isActive,
                            'text-ink' => ! $isActive,
                        ])
                        @if ($isActive) aria-current="page" @endif
                    >
                        <span>{{ $link['label'] }}</span>
                        <span aria-hidden="true" class="text-ink-soft">{{ $isActive ? '●' : '→' }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</header>
