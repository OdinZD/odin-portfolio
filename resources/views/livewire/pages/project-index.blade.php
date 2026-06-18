<div>
    {{-- Header --}}
    <section class="mx-auto max-w-5xl px-5 pt-16 sm:px-8 sm:pt-24">
        <x-eyebrow class="mb-6">{{ __('projects.index_eyebrow') }}</x-eyebrow>
        <h1 class="max-w-3xl font-mono text-3xl font-bold leading-[1.12] tracking-tight text-ink sm:text-5xl">
            {{ __('projects.index_heading') }}
        </h1>
        <p class="mt-6 max-w-xl text-lg leading-relaxed text-ink-soft">
            {{ __('projects.index_intro') }}
        </p>
    </section>

    {{-- Filter bar --}}
    <section class="mx-auto max-w-5xl px-5 pt-12 sm:px-8">
        <div class="flex flex-wrap items-center gap-2 border-y border-line py-4">
            <span class="mr-2 font-mono text-xs uppercase tracking-[0.2em] text-ink-soft">{{ __('projects.filter') }}</span>

            <button
                type="button"
                wire:click="$set('tech', '')"
                @class([
                    'border px-3 py-1 font-mono text-xs transition-colors',
                    'border-ink bg-ink text-paper' => $tech === '',
                    'border-line bg-paper text-ink-soft hover:border-ink hover:text-ink' => $tech !== '',
                ])
                @if ($tech === '') aria-current="true" @endif
            >
                {{ __('projects.all') }}
            </button>

            @foreach ($tags as $tag)
                <button
                    type="button"
                    wire:click="filterBy('{{ $tag }}')"
                    @class([
                        'border px-3 py-1 font-mono text-xs transition-colors',
                        'border-ink bg-amber text-ink' => $tech === $tag,
                        'border-line bg-paper text-ink-soft hover:border-ink hover:text-ink' => $tech !== $tag,
                    ])
                    @if ($tech === $tag) aria-current="true" @endif
                >
                    {{ $tag }}
                </button>
            @endforeach
        </div>
    </section>

    {{-- Grid --}}
    <section class="mx-auto max-w-5xl px-5 pb-10 pt-10 sm:px-8">
        <p class="mb-6 font-mono text-xs text-ink-soft">
            {{ trans_choice('projects.count', $projects->count(), ['count' => $projects->count()]) }}@if ($tech) <span class="text-ink">·</span> {{ __('projects.filtered_by') }} <span class="text-amber-deep">{{ $tech }}</span>@endif
        </p>

        @if ($projects->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <x-project-card :project="$project" wire:key="project-{{ $project->id }}" />
                @endforeach
            </div>
        @else
            <div class="border border-dashed border-line bg-card p-12 text-center">
                <p class="font-mono text-sm text-ink-soft">{{ __('projects.none_match') }}</p>
                <button type="button" wire:click="$set('tech', '')" class="mt-3 font-mono text-sm text-teal hover:text-amber-deep">
                    {{ __('projects.clear_filter') }}
                </button>
            </div>
        @endif
    </section>
</div>
