<div>
    {{-- Intro --}}
    <section class="mx-auto max-w-5xl px-5 pt-16 sm:px-8 sm:pt-24">
        <x-eyebrow class="mb-6">{{ __('about.eyebrow') }}</x-eyebrow>
        <h1 class="max-w-3xl font-mono text-3xl font-bold leading-[1.12] tracking-tight text-ink sm:text-5xl">
            {{ __('about.heading') }}
        </h1>
    </section>

    {{-- Bio + facts --}}
    <section class="mx-auto max-w-5xl px-5 py-14 sm:px-8">
        <div class="grid gap-12 md:grid-cols-[1.5fr_1fr]">
            {{-- Narrative, set like a typed letter --}}
            <div class="space-y-5 text-lg leading-relaxed text-ink-soft">
                <p class="font-mono text-sm uppercase tracking-[0.15em] text-ink">{{ __('about.hello') }}</p>
                @foreach (__('about.bio') as $paragraph)
                    <p>{!! $paragraph !!}</p>
                @endforeach
            </div>

            {{-- Spec card --}}
            <aside class="h-fit border border-ink bg-card shadow-[5px_5px_0_0_var(--color-ink)]">
                <div class="flex items-center justify-between border-b border-ink px-5 py-3">
                    <span class="font-mono text-xs uppercase tracking-[0.2em] text-ink-soft">{{ __('about.profile_label') }}</span>
                    <x-stamp status="Live" rotate="-3deg" />
                </div>
                <dl class="divide-y divide-line px-5 font-mono text-sm">
                    @foreach (__('about.profile') as $fact)
                        <div class="flex items-baseline py-3">
                            <dt class="uppercase tracking-[0.12em] text-ink-soft">{{ $fact['k'] }}</dt>
                            <span aria-hidden="true" class="dot-leader"></span>
                            <dd class="text-right text-ink">{{ $fact['v'] }}</dd>
                        </div>
                    @endforeach
                </dl>
                <div class="border-t border-ink p-5">
                    <x-btn :href="route('contact')" variant="primary" size="md" class="w-full">{{ __('about.get_in_touch') }}</x-btn>
                </div>
            </aside>
        </div>
    </section>

    {{-- Toolkit --}}
    <section class="border-y border-line bg-card">
        <div class="mx-auto max-w-5xl px-5 py-16 sm:px-8">
            <x-eyebrow class="mb-3">{{ __('about.toolkit_eyebrow') }}</x-eyebrow>
            <h2 class="mb-10 max-w-2xl font-mono text-2xl font-bold tracking-tight text-ink sm:text-3xl">
                {{ __('about.toolkit_heading') }}
            </h2>

            <div class="grid gap-8 sm:grid-cols-3">
                @foreach (__('about.toolkit') as $group)
                    <div>
                        <h3 class="mb-4 font-mono text-xs uppercase tracking-[0.2em] text-amber-deep">{{ $group['group'] }}</h3>
                        <ul class="flex flex-wrap gap-2">
                            @foreach ($group['items'] as $item)
                                <li><x-tag>{{ $item }}</x-tag></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Principles --}}
    <section class="mx-auto max-w-5xl px-5 py-16 sm:px-8">
        <x-eyebrow class="mb-3">{{ __('about.principles_eyebrow') }}</x-eyebrow>
        <h2 class="mb-10 max-w-2xl font-mono text-2xl font-bold tracking-tight text-ink sm:text-3xl">
            {{ __('about.principles_heading') }}
        </h2>

        <div class="grid gap-6 sm:grid-cols-2">
            @foreach (__('about.principles') as $principle)
                <div class="border-l-2 border-teal pl-5">
                    <h3 class="font-mono text-lg font-bold text-ink">{{ $principle['title'] }}</h3>
                    <p class="mt-2 leading-relaxed text-ink-soft">{{ $principle['body'] }}</p>
                </div>
            @endforeach
        </div>
    </section>
</div>
