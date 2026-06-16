<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Contact')]
final class Contact extends Component
{
    #[Validate('required|string|min:2|max:120')]
    public string $name = '';

    #[Validate('required|email|max:190')]
    public string $email = '';

    #[Validate('nullable|string|max:160')]
    public string $subject = '';

    #[Validate('required|string|min:10|max:5000')]
    public string $message = '';

    /** Honeypot — real people leave this blank. */
    public string $website = '';

    public bool $sent = false;

    public function submit(): void
    {
        // Quietly swallow obvious bots without tipping them off.
        if ($this->website !== '') {
            $this->sent = true;

            return;
        }

        $key = 'contact:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('message', 'You have sent a few messages already — please try again in a minute.');

            return;
        }

        $validated = $this->validate();

        RateLimiter::hit($key, 60);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] !== '' ? $validated['subject'] : null,
            'message' => $validated['message'],
            'meta' => [
                'ip' => request()->ip(),
                'user_agent' => (string) request()->userAgent(),
            ],
        ]);

        $this->reset(['name', 'email', 'subject', 'message']);
        $this->sent = true;
    }

    public function render(): View
    {
        return view('livewire.pages.contact');
    }
}
