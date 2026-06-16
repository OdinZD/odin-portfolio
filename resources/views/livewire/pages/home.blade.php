<div>
    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="mx-auto max-w-5xl px-5 pb-16 pt-16 sm:px-8 sm:pt-24">
            <x-eyebrow class="mb-6">Freelance web developer — available for work</x-eyebrow>

            <h1 class="font-mono text-4xl font-bold leading-[1.08] tracking-tight text-ink sm:text-6xl">
                I build web applications<br class="hidden sm:block">
                <span class="sm:hidden"> </span>that
                <x-typewriter
                    class="text-amber-deep"
                    :phrases="[
                        'ship.',
                        'earn their keep.',
                        'people come back to.',
                        'won\'t wake you at 3am.',
                    ]"
                    :speed="60"
                    :pause="1900"
                />
            </h1>

            <p class="mt-7 max-w-xl text-lg leading-relaxed text-ink-soft">
                I'm Odin Wolf — a freelance developer who designs, builds, and ships production
                software end to end. Founders and small teams hire me to turn an idea into a web
                app their customers actually use.
            </p>

            <div class="mt-9 flex flex-wrap items-center gap-4">
                <x-btn :href="route('projects.index')" variant="primary" size="lg">View the work →</x-btn>
                <x-btn :href="route('contact')" variant="ghost" size="lg">Start a project</x-btn>
            </div>

            {{-- Typed meta strip --}}
            <dl class="mt-14 grid max-w-2xl gap-y-3 border-t border-line pt-6 font-mono text-sm">
                @php
                    $meta = [
                        'Stack' => 'Laravel · Livewire · Tailwind',
                        'Based' => 'Remote · working worldwide',
                        'Shipped' => $shipped.' projects and counting',
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
                <x-eyebrow class="mb-3">Selected work</x-eyebrow>
                <h2 class="font-mono text-2xl font-bold tracking-tight text-ink sm:text-3xl">Recent builds</h2>
            </div>
            <a href="{{ route('projects.index') }}" class="hidden font-mono text-sm text-teal hover:text-amber-deep sm:inline">
                All projects →
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
                No featured projects yet. Mark a project as featured to show it here.
            </p>
        @endif

        <a href="{{ route('projects.index') }}" class="mt-8 inline-block font-mono text-sm text-teal hover:text-amber-deep sm:hidden">
            All projects →
        </a>
    </section>

    {{-- What I build --}}
    <section class="border-y border-line bg-card">
        <div class="mx-auto max-w-5xl px-5 py-16 sm:px-8">
            <x-eyebrow class="mb-3">What I build</x-eyebrow>
            <h2 class="mb-10 max-w-2xl font-mono text-2xl font-bold tracking-tight text-ink sm:text-3xl">
                The kind of work I'm hired for
            </h2>

            @php
                $services = [
                    ['title' => 'Web applications', 'body' => 'SaaS products, dashboards, internal tools, and client portals — built to handle real users and real data.'],
                    ['title' => 'Zero to launched', 'body' => 'From a rough idea to a deployed product: design, build, set up hosting, and hand you something that runs.'],
                    ['title' => 'Rescue & grow', 'body' => 'Inherited a codebase that\'s holding you back? I stabilise it, clean it up, and ship the features you\'ve been waiting on.'],
                ];
            @endphp
            <div class="grid gap-px overflow-hidden border border-ink bg-ink sm:grid-cols-3">
                @foreach ($services as $i => $service)
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
        <x-eyebrow class="mb-3">How it works</x-eyebrow>
        <h2 class="mb-10 max-w-2xl font-mono text-2xl font-bold tracking-tight text-ink sm:text-3xl">
            A simple way to work together
        </h2>

        @php
            $steps = [
                ['n' => '01', 'title' => 'Scope', 'body' => 'We talk through what you need and why. I write it down as a clear, fixed plan with a price and a timeline.'],
                ['n' => '02', 'title' => 'Build', 'body' => 'I build in the open with regular check-ins, so you see progress every week and nothing comes as a surprise.'],
                ['n' => '03', 'title' => 'Ship', 'body' => 'We launch, I make sure it runs in production, and I stay around to fix and grow it as you need.'],
            ];
        @endphp
        <ol class="grid gap-6 sm:grid-cols-3">
            @foreach ($steps as $step)
                <li class="border-l-2 border-amber pl-5">
                    <span class="font-mono text-3xl font-bold text-line">{{ $step['n'] }}</span>
                    <h3 class="mt-2 font-mono text-lg font-bold text-ink">{{ $step['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink-soft">{{ $step['body'] }}</p>
                </li>
            @endforeach
        </ol>
    </section>
</div>
