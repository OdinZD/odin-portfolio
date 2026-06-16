<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class ProjectShow extends Component
{
    public Project $project;

    public function mount(Project $project): void
    {
        $this->project = $project;
    }

    public function render(): View
    {
        $more = Project::ordered()
            ->whereKeyNot($this->project->getKey())
            ->take(2)
            ->get();

        return view('livewire.pages.project-show', [
            'more' => $more,
        ])->title($this->project->title);
    }
}
