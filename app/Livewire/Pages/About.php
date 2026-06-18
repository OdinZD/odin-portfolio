<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class About extends Component
{
    public function render(): View
    {
        return view('livewire.pages.about')->title(__('about.title'));
    }
}
