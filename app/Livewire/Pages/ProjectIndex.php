<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class ProjectIndex extends Component
{
    #[Url(as: 'tech', keep: false)]
    public string $tech = '';

    /**
     * Toggle a tech filter on/off.
     */
    public function filterBy(string $tech): void
    {
        $this->tech = $this->tech === $tech ? '' : $tech;
    }

    public function render(): View
    {
        $all = Project::ordered()->get();

        $tags = $all
            ->flatMap(fn (Project $p): array => $p->tech_stack ?? [])
            ->unique()
            ->sort()
            ->values();

        $projects = $this->tech === ''
            ? $all
            : $all->filter(fn (Project $p): bool => in_array($this->tech, $p->tech_stack ?? [], true))->values();

        return view('livewire.pages.project-index', [
            'projects' => $projects,
            'tags' => $tags,
        ])->title(__('projects.title'));
    }
}
