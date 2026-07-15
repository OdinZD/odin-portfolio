<div>
    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="mx-auto max-w-5xl px-5 pb-16 pt-16 sm:px-8 sm:pt-24">
            <x-eyebrow class="mb-6">{{ __('home.hero_eyebrow') }}</x-eyebrow>

            @php
                $phrases = __('home.typewriter');
                // Monospace title, so the phrase with the most characters always wraps
                // to the tallest state — use it to reserve height (see the sizer below).
                $longestPhrase = collect($phrases)->sortByDesc(fn ($p) => mb_strlen((string) $p))->first();
            @endphp

            {{-- The animated title is overlaid on an invisible sizer pinned to the
                 tallest line-wrap, so the intro paragraph below never shifts while the
                 typewriter cycles through phrases of different lengths. --}}
            <div class="relative">
                {{-- Inline visibility:hidden (not Tailwind's `invisible`) so it works
                     against the prebuilt production CSS without an asset rebuild. --}}
                <p aria-hidden="true" style="visibility: hidden;" class="font-mono text-4xl font-bold leading-[1.08] tracking-tight sm:text-6xl">
                    {{ __('home.hero_title_lead') }}<br class="hidden sm:block">
                    <span class="sm:hidden"> </span>{{ __('home.hero_title_that') }}
                    <span>{{ $longestPhrase }}</span><span class="caret"></span>
                </p>

                <h1 class="absolute inset-0 font-mono text-4xl font-bold leading-[1.08] tracking-tight text-ink sm:text-6xl">
                    {{ __('home.hero_title_lead') }}<br class="hidden sm:block">
                    <span class="sm:hidden"> </span>{{ __('home.hero_title_that') }}
                    <x-typewriter
                        class="text-amber-deep"
                        :phrases="$phrases"
                        :speed="60"
                        :pause="1900"
                    />
                </h1>
            </div>

            <p class="mt-7 max-w-xl text-lg leading-relaxed text-ink-soft">
                {{ __('home.hero_intro') }}
            </p>

            <div class="mt-9 flex flex-wrap items-center gap-4">
                <x-btn :href="route('projects.index')" variant="primary" size="lg">{{ __('home.cta_view_work') }}</x-btn>
                <x-btn :href="route('contact')" variant="ghost" size="lg">{{ __('home.cta_start') }}</x-btn>
            </div>

            {{-- Typed meta strip --}}
            <dl class="mt-14 grid max-w-2xl gap-y-3 border-t border-line pt-6 font-mono text-sm">
                @php
                    $meta = [
                        __('home.meta.stack_label') => __('home.meta.stack_value'),
                        __('home.meta.based_label') => __('home.meta.based_value'),
                        __('home.meta.shipped_label') => trans_choice('home.meta.shipped_value', $shipped, ['count' => $shipped]),
                    ];
                @endphp
                @foreach ($meta as $label => $value)
                    <div class="flex flex-wrap items-baseline gap-x-3 sm:flex-nowrap">
                        <dt class="uppercase tracking-[0.15em] text-ink-soft">{{ $label }}</dt>
                        <span aria-hidden="true" class="dot-leader hidden sm:block"></span>
                        <dd class="text-ink">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- Featured work --}}
    <section class="mx-auto max-w-5xl px-5 py-16 sm:px-8">
        <div class="mb-8 flex items-end justify-between gap-4">
            <div>
                <x-eyebrow class="mb-3">{{ __('home.selected_work') }}</x-eyebrow>
                <h2 class="font-mono text-2xl font-bold tracking-tight text-ink sm:text-3xl">{{ __('home.recent_builds') }}</h2>
            </div>
            <a href="{{ route('projects.index') }}" class="hidden font-mono text-sm text-teal hover:text-amber-deep sm:inline">
                {{ __('home.all_projects') }}
            </a>
        </div>

        @if ($featured->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featured as $project)
                    <x-project-card :project="$project" />
                @endforeach
            </div>
        @else
            <p class="border border-dashed border-line bg-card p-8 text-center font-mono text-sm text-ink-soft">
                {{ __('home.no_featured') }}
            </p>
        @endif

        <a href="{{ route('projects.index') }}" class="mt-8 inline-block font-mono text-sm text-teal hover:text-amber-deep sm:hidden">
            {{ __('home.all_projects') }}
        </a>
    </section>

    {{-- What I build --}}
    <section class="border-y border-line bg-card">
        <div class="mx-auto max-w-5xl px-5 py-16 sm:px-8">
            <x-eyebrow class="mb-3">{{ __('home.what_i_build') }}</x-eyebrow>
            <h2 class="mb-10 max-w-2xl font-mono text-2xl font-bold tracking-tight text-ink sm:text-3xl">
                {{ __('home.what_i_build_heading') }}
            </h2>

            <div class="grid gap-px overflow-hidden border border-ink bg-ink sm:grid-cols-3">
                @foreach (__('home.services') as $i => $service)
                    <div class="bg-card p-7">
                        <span class="font-mono text-xs text-amber-deep">0{{ $i + 1 }}</span>
                        <h3 class="mt-3 font-mono text-lg font-bold text-ink">{{ $service['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink-soft">{{ $service['body'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="mx-auto max-w-5xl px-5 py-16 sm:px-8">
        <x-eyebrow class="mb-3">{{ __('home.how_it_works') }}</x-eyebrow>
        <h2 class="mb-10 max-w-2xl font-mono text-2xl font-bold tracking-tight text-ink sm:text-3xl">
            {{ __('home.how_it_works_heading') }}
        </h2>

        <ol class="grid gap-6 sm:grid-cols-3">
            @foreach (__('home.steps') as $step)
                <li class="border-l-2 border-amber pl-5">
                    <span class="font-mono text-3xl font-bold text-line">{{ $step['n'] }}</span>
                    <h3 class="mt-2 font-mono text-lg font-bold text-ink">{{ $step['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink-soft">{{ $step['body'] }}</p>
                </li>
            @endforeach
        </ol>
    </section>
</div>
