<?php

use App\Livewire\Pages\Contact;
use App\Models\ContactMessage;
use Livewire\Livewire;

it('stores a valid contact message', function () {
    Livewire::test(Contact::class)
        ->set('name', 'Jane Doe')
        ->set('email', 'jane@example.com')
        ->set('subject', 'A new app')
        ->set('message', 'I would like to build a web application with you.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('sent', true);

    expect(ContactMessage::count())->toBe(1);

    $message = ContactMessage::first();
    expect($message->name)->toBe('Jane Doe')
        ->and($message->email)->toBe('jane@example.com')
        ->and($message->subject)->toBe('A new app');
});

it('requires the core fields', function () {
    Livewire::test(Contact::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'message'])
        ->assertSet('sent', false);

    expect(ContactMessage::count())->toBe(0);
});

it('rejects an invalid email', function () {
    Livewire::test(Contact::class)
        ->set('name', 'Jane Doe')
        ->set('email', 'not-an-email')
        ->set('message', 'A perfectly long enough message here.')
        ->call('submit')
        ->assertHasErrors(['email']);

    expect(ContactMessage::count())->toBe(0);
});

it('silently drops honeypot (bot) submissions', function () {
    Livewire::test(Contact::class)
        ->set('name', 'Spam Bot')
        ->set('email', 'bot@example.com')
        ->set('message', 'buy cheap things at spam dot example')
        ->set('website', 'http://spam.example')
        ->call('submit')
        ->assertSet('sent', true);

    expect(ContactMessage::count())->toBe(0);
});
