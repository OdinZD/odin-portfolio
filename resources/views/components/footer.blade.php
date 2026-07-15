@php
    $email = 'odinwolfperica@gmail.com';
    $socials = [
        ['label' => 'GitHub', 'url' => 'https://github.com/OdinZD'],
        ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/odin-wolf-perica-b7b99ba4'],
        ['label' => 'Email', 'url' => 'mailto:' . $email],
    ];
@endphp

<footer class="mt-24 border-t-2 border-ink bg-paper-deep">
    {{-- Closing CTA --}}
    <div class="border-b border-line">
        <div class="mx-auto flex max-w-5xl flex-col items-start justify-between gap-6 px-5 py-12 sm:px-8 md:flex-row md:items-center">
            <div>
                <x-eyebrow class="mb-3">{{ __('footer.open_for_work') }}</x-eyebrow>
                <p class="max-w-md font-mono text-xl font-bold leading-snug text-ink sm:text-2xl">
                    {{ __('footer.cta_heading') }}
                </p>
            </div>
            <x-btn :href="route('contact')" variant="ink" size="lg">{{ __('footer.cta_button') }}</x-btn>
        </div>
    </div>

    {{-- Columns --}}
    <div class="mx-auto grid max-w-5xl gap-10 px-5 py-12 sm:px-8 md:grid-cols-[1.4fr_1fr_1fr]">
        <div>
            <a href="{{ route('home') }}" class="group inline-flex items-center" aria-label="{{ __('nav.home_aria') }}">
                <img
                    src="{{ asset('images/Odin-Wolf.png') }}"
                    alt="Odin Wolf"
                    width="1260"
                    height="744"
                    class="h-10 w-auto transition-opacity group-hover:opacity-80"
                >
            </a>
            <p class="mt-4 max-w-xs text-sm leading-relaxed text-ink-soft">
                {{ __('footer.blurb') }}
            </p>
        </div>

        <nav aria-label="Footer">
            <h2 class="mb-3 font-mono text-xs uppercase tracking-[0.2em] text-ink-soft">{{ __('footer.pages') }}</h2>
            <ul class="space-y-2 font-mono text-sm">
                <li><a href="{{ route('home') }}" class="text-ink hover:text-amber-deep">{{ __('footer.home') }}</a></li>
                <li><a href="{{ route('projects.index') }}" class="text-ink hover:text-amber-deep">{{ __('footer.projects') }}</a></li>
                <li><a href="{{ route('about') }}" class="text-ink hover:text-amber-deep">{{ __('footer.about') }}</a></li>
                <li><a href="{{ route('contact') }}" class="text-ink hover:text-amber-deep">{{ __('footer.contact') }}</a></li>
            </ul>
        </nav>

        <div>
            <h2 class="mb-3 font-mono text-xs uppercase tracking-[0.2em] text-ink-soft">{{ __('footer.elsewhere') }}</h2>
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
            <p>{{ __('footer.rights', ['year' => now()->year]) }}</p>
            <p class="opacity-80">{{ __('footer.attribution') }}</p>
        </div>
    </div>
</footer>
