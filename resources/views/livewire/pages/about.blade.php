<div>
    {{-- Intro --}}
    <section class="mx-auto max-w-5xl px-5 pt-16 sm:px-8 sm:pt-24">
        <x-eyebrow class="mb-6">About</x-eyebrow>
        <h1 class="max-w-3xl font-mono text-3xl font-bold leading-[1.12] tracking-tight text-ink sm:text-5xl">
            A developer who ships — and sticks around afterwards.
        </h1>
    </section>

    {{-- Bio + facts --}}
    <section class="mx-auto max-w-5xl px-5 py-14 sm:px-8">
        <div class="grid gap-12 md:grid-cols-[1.5fr_1fr]">
            {{-- Narrative, set like a typed letter --}}
            <div class="space-y-5 text-lg leading-relaxed text-ink-soft">
                <p class="font-mono text-sm uppercase tracking-[0.15em] text-ink">Hello — I'm Odin.</p>
                <p>
                    I'm a freelance web developer. For the past several years I've helped founders and
                    small teams turn ideas into working software — the kind people log into every day to
                    run their business.
                </p>
                <p>
                    I work across the whole stack, but my home is <span class="text-ink">Laravel</span> and
                    <span class="text-ink">Livewire</span>. That lets me move fast without leaving a mess
                    behind: clean code, sensible structure, and apps that are still easy to change a year
                    later.
                </p>
                <p>
                    Most of all, I care about <span class="text-ink">shipping</span>. A half-built feature
                    helps nobody. I'd rather scope tightly, build the thing that matters, get it in front
                    of real users, and improve from there.
                </p>
                <p>
                    When a project launches I don't disappear. I make sure it runs in production and stay
                    on hand to fix, tune, and grow it as your needs change.
                </p>
            </div>

            {{-- Spec card --}}
            <aside class="h-fit border border-ink bg-card shadow-[5px_5px_0_0_var(--color-ink)]">
                <div class="flex items-center justify-between border-b border-ink px-5 py-3">
                    <span class="font-mono text-xs uppercase tracking-[0.2em] text-ink-soft">Profile</span>
                    <x-stamp status="Live" rotate="-3deg" />
                </div>
                <dl class="divide-y divide-line px-5 font-mono text-sm">
                    @php
                        $facts = [
                            ['k' => 'Name', 'v' => 'Odin Wolf'],
                            ['k' => 'Role', 'v' => 'Web app developer'],
                            ['k' => 'Based', 'v' => 'Remote · worldwide'],
                            ['k' => 'Focus', 'v' => 'Laravel · Livewire'],
                            ['k' => 'Status', 'v' => 'Open to projects'],
                        ];
                    @endphp
                    @foreach ($facts as $fact)
                        <div class="flex items-baseline py-3">
                            <dt class="uppercase tracking-[0.12em] text-ink-soft">{{ $fact['k'] }}</dt>
                            <span aria-hidden="true" class="dot-leader"></span>
                            <dd class="text-right text-ink">{{ $fact['v'] }}</dd>
                        </div>
                    @endforeach
                </dl>
                <div class="border-t border-ink p-5">
                    <x-btn :href="route('contact')" variant="primary" size="md" class="w-full">Get in touch →</x-btn>
                </div>
            </aside>
        </div>
    </section>

    {{-- Toolkit --}}
    <section class="border-y border-line bg-card">
        <div class="mx-auto max-w-5xl px-5 py-16 sm:px-8">
            <x-eyebrow class="mb-3">The toolkit</x-eyebrow>
            <h2 class="mb-10 max-w-2xl font-mono text-2xl font-bold tracking-tight text-ink sm:text-3xl">
                What I work with
            </h2>

            @php
                $toolkit = [
                    'Backend' => ['Laravel', 'PHP', 'MySQL', 'PostgreSQL', 'Redis', 'REST APIs'],
                    'Frontend' => ['Livewire', 'Alpine.js', 'Tailwind CSS', 'Vite', 'JavaScript'],
                    'Shipping' => ['Git', 'Pest', 'CI/CD', 'Docker', 'Forge', 'Cloud hosting'],
                ];
            @endphp
            <div class="grid gap-8 sm:grid-cols-3">
                @foreach ($toolkit as $group => $items)
                    <div>
                        <h3 class="mb-4 font-mono text-xs uppercase tracking-[0.2em] text-amber-deep">{{ $group }}</h3>
                        <ul class="flex flex-wrap gap-2">
                            @foreach ($items as $item)
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
        <x-eyebrow class="mb-3">How I work</x-eyebrow>
        <h2 class="mb-10 max-w-2xl font-mono text-2xl font-bold tracking-tight text-ink sm:text-3xl">
            A few things I hold to
        </h2>

        @php
            $principles = [
                ['title' => 'Ship over polish', 'body' => 'Working software in real hands beats a perfect plan on paper. We launch, then we sharpen.'],
                ['title' => 'No surprises', 'body' => 'Clear scope, honest estimates, and weekly check-ins. You always know where things stand.'],
                ['title' => 'Built to last', 'body' => 'Readable code and tests, so the app is still easy and cheap to change long after launch.'],
                ['title' => 'Your goals first', 'body' => 'I\'m here to move your business, not to chase the newest framework for its own sake.'],
            ];
        @endphp
        <div class="grid gap-6 sm:grid-cols-2">
            @foreach ($principles as $principle)
                <div class="border-l-2 border-teal pl-5">
                    <h3 class="font-mono text-lg font-bold text-ink">{{ $principle['title'] }}</h3>
                    <p class="mt-2 leading-relaxed text-ink-soft">{{ $principle['body'] }}</p>
                </div>
            @endforeach
        </div>
    </section>
</div>
