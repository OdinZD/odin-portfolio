<?php

use App\Livewire\Pages\ProjectIndex;
use App\Models\Project;
use Livewire\Livewire;

it('shows a project case study', function () {
    $project = Project::factory()->create([
        'title' => 'Acme App',
        'slug' => 'acme-app',
        'tagline' => 'A one-of-a-kind tagline for testing.',
    ]);

    $this->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee('Acme App')
        ->assertSee('A one-of-a-kind tagline for testing.');
});

it('returns 404 for an unknown project', function () {
    $this->get('/projects/this-does-not-exist')->assertNotFound();
});

it('filters projects by tech tag', function () {
    Project::factory()->create(['title' => 'Laravel One', 'tech_stack' => ['Laravel']]);
    Project::factory()->create(['title' => 'Vue Two', 'tech_stack' => ['Vue']]);

    Livewire::test(ProjectIndex::class)
        ->assertSee('Laravel One')
        ->assertSee('Vue Two')
        ->call('filterBy', 'Laravel')
        ->assertSet('tech', 'Laravel')
        ->assertSee('Laravel One')
        ->assertDontSee('Vue Two')
        ->call('filterBy', 'Laravel') // toggling off clears the filter
        ->assertSet('tech', '')
        ->assertSee('Vue Two');
});
