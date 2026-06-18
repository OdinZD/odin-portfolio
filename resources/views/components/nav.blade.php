@php
    $links = [
        ['label' => __('nav.home'), 'route' => 'home', 'active' => 'home'],
        ['label' => __('nav.projects'), 'route' => 'projects.index', 'active' => 'projects.*'],
        ['label' => __('nav.about'), 'route' => 'about', 'active' => 'about'],
        ['label' => __('nav.contact'), 'route' => 'contact', 'active' => 'contact'],
    ];
    $locales = config('app.available_locales');
@endphp

<header
    x-data="{ open: false }"
    class="sticky top-0 z-40 border-b border-line/80 bg-paper/85 backdrop-blur-sm"
>
    <div class="mx-auto flex max-w-5xl items-center justify-between px-5 py-4 sm:px-8">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="group inline-flex items-center" aria-label="{{ __('nav.home_aria') }}">
            <img
                src="{{ asset('images/Odin-Wolf.png') }}"
                alt="Odin Wolf"
                width="1260"
                height="744"
                class="h-8 w-auto sm:h-9 transition-opacity group-hover:opacity-80"
            >
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

            {{-- Language switcher --}}
            <div class="flex items-center gap-1.5 border-l border-line pl-5 font-mono text-xs" role="group" aria-label="{{ __('nav.language') }}">
                @foreach ($locales as $code => $label)
                    @php $isCurrent = app()->getLocale() === $code; @endphp
                    <a
                        href="{{ route('locale.switch', $code) }}"
                        @class([
                            'uppercase tracking-[0.1em] transition-colors',
                            'text-amber-deep' => $isCurrent,
                            'text-ink-soft hover:text-ink' => ! $isCurrent,
                        ])
                        @if ($isCurrent) aria-current="true" @endif
                    >{{ $label }}</a>
                    @if (! $loop->last)<span aria-hidden="true" class="text-line">/</span>@endif
                @endforeach
            </div>

            <x-btn :href="route('contact')" variant="primary" size="sm">{{ __('nav.start_project') }}</x-btn>
        </nav>

        {{-- Mobile toggle --}}
        <button
            type="button"
            class="inline-flex items-center gap-2 font-mono text-sm md:hidden"
            x-on:click="open = ! open"
            :aria-expanded="open.toString()"
            aria-controls="mobile-menu"
        >
            <span x-text="open ? '{{ __('nav.close') }}' : '{{ __('nav.menu') }}'">{{ __('nav.menu') }}</span>
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
            <li>
                <div class="flex items-center gap-3 py-4 font-mono text-sm" role="group" aria-label="{{ __('nav.language') }}">
                    <span class="text-ink-soft">{{ __('nav.language') }}:</span>
                    @foreach ($locales as $code => $label)
                        @php $isCurrent = app()->getLocale() === $code; @endphp
                        <a
                            href="{{ route('locale.switch', $code) }}"
                            @class([
                                'uppercase tracking-[0.1em]',
                                'text-amber-deep' => $isCurrent,
                                'text-ink' => ! $isCurrent,
                            ])
                            @if ($isCurrent) aria-current="true" @endif
                        >{{ $label }}</a>
                        @if (! $loop->last)<span aria-hidden="true" class="text-line">/</span>@endif
                    @endforeach
                </div>
            </li>
        </ul>
    </nav>
</header>
