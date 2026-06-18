<?php

it('renders English by default', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('lang="en"', false)
        ->assertSee('Projects');
});

it('renders Croatian when the locale cookie is set', function () {
    $this->withUnencryptedCookie('locale', 'hr')
        ->get(route('home'))
        ->assertOk()
        ->assertSee('lang="hr"', false)
        ->assertSee('Projekti')
        ->assertSee('Gradim web aplikacije');
});

it('translates the contact form into Croatian', function () {
    $this->withUnencryptedCookie('locale', 'hr')
        ->get(route('contact'))
        ->assertOk()
        ->assertSee('Pošalji poruku →')
        ->assertSee('Recite mi što gradite.');
});

it('switches locale and redirects back with a cookie', function () {
    $response = $this->get(route('locale.switch', 'hr'));

    $response->assertRedirect();
    $response->assertCookie('locale');
});

it('rejects an unsupported locale', function () {
    $this->get('/locale/de')->assertNotFound();
});
