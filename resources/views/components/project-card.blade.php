@props(['project'])

@php
    // Generated cover palette — literal classes so Tailwind keeps them.
    $covers = [
        ['bg' => 'bg-amber', 'fg' => 'text-ink', 'sub' => 'text-ink/55', 'grid' => 'text-ink/10'],
        ['bg' => 'bg-teal', 'fg' => 'text-paper', 'sub' => 'text-paper/70', 'grid' => 'text-paper/10'],
        ['bg' => 'bg-ink', 'fg' => 'text-amber', 'sub' => 'text-paper/55', 'grid' => 'text-paper/10'],
        ['bg' => 'bg-rust', 'fg' => 'text-paper', 'sub' => 'text-paper/70', 'grid' => 'text-paper/10'],
    ];
    $seed = (int) ($project->id ?? crc32((string) $project->title));
    $cover = $covers[$seed % count($covers)];

    $words = preg_split('/\s+/', trim((string) $project->title));
    $initials = strtoupper(mb_substr($words[0] ?? '', 0, 1) . mb_substr($words[1] ?? ($words[0] ?? ''), 0, 1));

    $hasImage = filled($project->cover_image);
    $imageSrc = $hasImage
        ? (str_starts_with($project->cover_image, 'http') || str_starts_with($project->cover_image, '/')
            ? $project->cover_image
            : asset('images/projects/' . $project->cover_image))
        : null;

    $stack = collect($project->tech_stack ?? [])->take(4);
    $fileNo = str_pad((string) $seed, 3, '0', STR_PAD_LEFT);
    $fileNo = substr($fileNo, -3);
@endphp

<a
    href="{{ route('projects.show', $project) }}"
    class="group flex flex-col border border-ink bg-card transition-all duration-150 hover:-translate-y-1 hover:shadow-[6px_6px_0_0_var(--color-ink)] focus-visible:-translate-y-1 focus-visible:shadow-[6px_6px_0_0_var(--color-ink)]"
>
    {{-- Cover --}}
    <div class="relative aspect-[16/10] overflow-hidden border-b border-ink">
        @if ($hasImage)
            <img
                src="{{ $imageSrc }}"
                alt="Screenshot of {{ $project->title }}"
                class="h-full w-full object-cover"
                loading="lazy"
            >
        @else
            <div class="{{ $cover['bg'] }} relative flex h-full w-full items-center justify-center overflow-hidden">
                <span aria-hidden="true" class="{{ $cover['grid'] }} pointer-events-none absolute inset-0 select-none font-mono text-[0.6rem] leading-4 break-words p-2 opacity-60">{{ str_repeat($initials . ' ', 200) }}</span>
                <span aria-hidden="true" class="{{ $cover['fg'] }} relative font-mono text-6xl font-bold tracking-tighter">{{ $initials }}</span>
            </div>
        @endif

        <span class="absolute left-3 top-3 font-mono text-[0.65rem] uppercase tracking-[0.15em] {{ $hasImage ? 'bg-ink/80 px-1.5 py-0.5 text-paper' : $cover['sub'] }}">
            FILE&nbsp;{{ $fileNo }}
        </span>

        <span class="absolute right-3 top-3">
            <x-stamp :status="$project->status" :year="$project->year" />
        </span>
    </div>

    {{-- Body --}}
    <div class="flex flex-1 flex-col gap-3 p-5">
        <div class="flex items-baseline justify-between gap-3">
            <h3 class="font-mono text-lg font-bold leading-tight text-ink">{{ $project->title }}</h3>
            <span class="font-mono text-xs text-ink-soft">{{ $project->year }}</span>
        </div>

        <p class="text-sm leading-relaxed text-ink-soft">{{ $project->tagline }}</p>

        <div class="mt-auto flex items-baseline font-mono text-xs text-ink-soft">
            <span class="uppercase tracking-[0.15em]">{{ $project->role }}</span>
            <span aria-hidden="true" class="dot-leader"></span>
            <span class="text-teal transition-colors group-hover:text-amber-deep">open&nbsp;→</span>
        </div>

        @if ($stack->isNotEmpty())
            <div class="flex flex-wrap gap-1.5 pt-1">
                @foreach ($stack as $tech)
                    <x-tag>{{ $tech }}</x-tag>
                @endforeach
            </div>
        @endif
    </div>
</a>
