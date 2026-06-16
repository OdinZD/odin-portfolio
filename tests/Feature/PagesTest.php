<?php

use App\Models\Project;

it('renders the home page', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('web applications');
});

it('renders the about page', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee('Odin');
});

it('renders the projects index', function () {
    Project::factory()->create(['title' => 'Sample Build']);

    $this->get(route('projects.index'))
        ->assertOk()
        ->assertSee('Sample Build');
});

it('renders the contact page', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('Contact');
});
