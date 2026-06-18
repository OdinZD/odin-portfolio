<div>
    @php
        $covers = [
            ['bg' => 'bg-amber', 'fg' => 'text-ink', 'grid' => 'text-ink/10'],
            ['bg' => 'bg-teal', 'fg' => 'text-paper', 'grid' => 'text-paper/10'],
            ['bg' => 'bg-ink', 'fg' => 'text-amber', 'grid' => 'text-paper/10'],
            ['bg' => 'bg-rust', 'fg' => 'text-paper', 'grid' => 'text-paper/10'],
        ];
        $cover = $covers[(int) $project->id % count($covers)];
        $words = preg_split('/\s+/', trim($project->title));
        $initials = strtoupper(mb_substr($words[0] ?? '', 0, 1) . mb_substr($words[1] ?? ($words[0] ?? ''), 0, 1));
        $hasImage = filled($project->cover_image);
        $imageSrc = $hasImage
            ? (str_starts_with($project->cover_image, 'http') || str_starts_with($project->cover_image, '/')
                ? $project->cover_image
                : asset('images/projects/' . $project->cover_image))
            : null;
        $paragraphs = preg_split('/\n\s*\n/', trim($project->t('body')));
    @endphp

    {{-- Header --}}
    <section class="mx-auto max-w-5xl px-5 pt-12 sm:px-8 sm:pt-16">
        <a href="{{ route('projects.index') }}" wire:navigate class="inline-flex items-center gap-2 font-mono text-sm text-teal hover:text-amber-deep">
            {{ __('projects.all_projects_back') }}
        </a>

        <div class="mt-8 flex flex-wrap items-start justify-between gap-4">
            <div>
                <span class="font-mono text-xs uppercase tracking-[0.2em] text-ink-soft">{{ $project->year }} · {{ $project->t('role') }}</span>
                <h1 class="mt-2 font-mono text-3xl font-bold leading-tight tracking-tight text-ink sm:text-5xl">{{ $project->title }}</h1>
            </div>
            <x-stamp :status="$project->status" :year="$project->year" rotate="-4deg" class="mt-2" />
        </div>

        <p class="mt-5 max-w-2xl text-lg leading-relaxed text-ink-soft">{{ $project->t('tagline') }}</p>
    </section>

    {{-- Cover --}}
    <section class="mx-auto max-w-5xl px-5 pt-10 sm:px-8">
        <div class="relative aspect-[2/1] overflow-hidden border border-ink bg-card shadow-[6px_6px_0_0_var(--color-ink)]">
            @if ($hasImage)
                <img src="{{ $imageSrc }}" alt="{{ __('projects.screenshot_of', ['title' => $project->title]) }}" class="h-full w-full object-cover">
            @else
                <div class="{{ $cover['bg'] }} relative flex h-full w-full items-center justify-center overflow-hidden">
                    <span aria-hidden="true" class="{{ $cover['grid'] }} pointer-events-none absolute inset-0 select-none break-words p-3 font-mono text-xs leading-5">{{ str_repeat($initials . ' ', 400) }}</span>
                    <span aria-hidden="true" class="{{ $cover['fg'] }} relative font-mono text-7xl font-bold tracking-tighter sm:text-8xl">{{ $initials }}</span>
                </div>
            @endif
        </div>
    </section>

    {{-- Body + meta --}}
    <section class="mx-auto max-w-5xl px-5 py-14 sm:px-8">
        <div class="grid gap-12 md:grid-cols-[1.6fr_1fr]">
            {{-- Case study --}}
            <article class="space-y-5 text-lg leading-relaxed text-ink-soft">
                <x-eyebrow class="mb-2" as="div">{{ __('projects.the_build') }}</x-eyebrow>
                @foreach ($paragraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </article>

            {{-- Meta file --}}
            <aside class="h-fit md:sticky md:top-24">
                <div class="border border-ink bg-card shadow-[5px_5px_0_0_var(--color-ink)]">
                    <div class="border-b border-ink px-5 py-3">
                        <span class="font-mono text-xs uppercase tracking-[0.2em] text-ink-soft">{{ __('projects.project_file') }}</span>
                    </div>
                    <dl class="divide-y divide-line px-5 font-mono text-sm">
                        @php
                            $rows = array_filter([
                                __('projects.role') => $project->t('role'),
                                __('projects.client') => $project->client,
                                __('projects.year') => $project->year,
                                __('projects.status') => __('common.statuses.' . (strtolower($project->status) === 'live' ? 'live' : 'shipped')),
                            ]);
                        @endphp
                        @foreach ($rows as $k => $v)
                            <div class="flex items-baseline py-3">
                                <dt class="uppercase tracking-[0.12em] text-ink-soft">{{ $k }}</dt>
                                <span aria-hidden="true" class="dot-leader"></span>
                                <dd class="text-right text-ink">{{ $v }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    @if (filled($project->tech_stack))
                        <div class="border-t border-line px-5 py-4">
                            <span class="mb-3 block font-mono text-xs uppercase tracking-[0.12em] text-ink-soft">{{ __('projects.stack') }}</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach ($project->tech_stack as $tech)
                                    <x-tag>{{ $tech }}</x-tag>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($project->live_url || $project->repo_url)
                        <div class="space-y-2 border-t border-ink p-5">
                            @if ($project->live_url)
                                <x-btn :href="$project->live_url" variant="primary" size="md" class="w-full" target="_blank" rel="noopener">
                                    {{ __('projects.visit_live') }}
                                </x-btn>
                            @endif
                            @if ($project->repo_url)
                                <x-btn :href="$project->repo_url" variant="ghost" size="md" class="w-full" target="_blank" rel="noopener">
                                    {{ __('projects.view_source') }}
                                </x-btn>
                            @endif
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </section>

    {{-- More work --}}
    @if ($more->isNotEmpty())
        <section class="border-t border-line bg-card">
            <div class="mx-auto max-w-5xl px-5 py-16 sm:px-8">
                <x-eyebrow class="mb-8">{{ __('projects.more_work') }}</x-eyebrow>
                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach ($more as $other)
                        <x-project-card :project="$other" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
