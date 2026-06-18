<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Home extends Component
{
    public function render(): View
    {
        return view('livewire.pages.home', [
            'featured' => Project::featured()->ordered()->take(3)->get(),
            'shipped' => Project::count(),
        ])->title(__('common.meta_title'));
    }
}
