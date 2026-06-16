@php
    $email = 'odinwolfperica@gmail.com';
    $socials = [
        ['label' => 'GitHub', 'url' => 'https://github.com/'],
        ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/'],
        ['label' => 'Email', 'url' => 'mailto:' . $email],
    ];
@endphp

<footer class="mt-24 border-t-2 border-ink bg-paper-deep">
    {{-- Closing CTA --}}
    <div class="border-b border-line">
        <div class="mx-auto flex max-w-5xl flex-col items-start justify-between gap-6 px-5 py-12 sm:px-8 md:flex-row md:items-center">
            <div>
                <x-eyebrow class="mb-3">Open for work</x-eyebrow>
                <p class="max-w-md font-mono text-xl font-bold leading-snug text-ink sm:text-2xl">
                    Have something worth shipping?
                </p>
            </div>
            <x-btn :href="route('contact')" variant="ink" size="lg">Start a project →</x-btn>
        </div>
    </div>

    {{-- Columns --}}
    <div class="mx-auto grid max-w-5xl gap-10 px-5 py-12 sm:px-8 md:grid-cols-[1.4fr_1fr_1fr]">
        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-mono text-base font-bold">
                <span class="grid h-6 w-6 place-items-center bg-ink text-xs text-paper">OW</span>
                <span class="text-ink">odin<span class="text-amber-deep">wolf</span></span>
            </a>
            <p class="mt-4 max-w-xs text-sm leading-relaxed text-ink-soft">
                Freelance web application developer. I design, build, and ship production software for
                founders and teams.
            </p>
        </div>

        <nav aria-label="Footer">
            <h2 class="mb-3 font-mono text-xs uppercase tracking-[0.2em] text-ink-soft">Pages</h2>
            <ul class="space-y-2 font-mono text-sm">
                <li><a href="{{ route('home') }}" class="text-ink hover:text-amber-deep">Home</a></li>
                <li><a href="{{ route('projects.index') }}" class="text-ink hover:text-amber-deep">Projects</a></li>
                <li><a href="{{ route('about') }}" class="text-ink hover:text-amber-deep">About</a></li>
                <li><a href="{{ route('contact') }}" class="text-ink hover:text-amber-deep">Contact</a></li>
            </ul>
        </nav>

        <div>
            <h2 class="mb-3 font-mono text-xs uppercase tracking-[0.2em] text-ink-soft">Elsewhere</h2>
            <ul class="space-y-2 font-mono text-sm">
                @foreach ($socials as $social)
                    <li>
                        <a href="{{ $social['url'] }}" class="group inline-flex items-center gap-2 text-ink hover:text-amber-deep">
                            <span aria-hidden="true" class="text-teal group-hover:text-amber-deep">↗</span>
                            {{ $social['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Baseline --}}
    <div class="border-t border-line">
        <div class="mx-auto flex max-w-5xl flex-col gap-2 px-5 py-5 font-mono text-xs text-ink-soft sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <p>© {{ now()->year }} Odin Wolf. All rights reserved.</p>
            <p class="opacity-80">Set in Space Mono — built with Laravel &amp; Livewire.</p>
        </div>
    </div>
</footer>
