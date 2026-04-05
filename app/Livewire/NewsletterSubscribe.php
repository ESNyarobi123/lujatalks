<?php

namespace App\Livewire;

use App\Models\Subscriber;
use Livewire\Component;

class NewsletterSubscribe extends Component
{
    public string $email = '';

    public bool $subscribed = false;

    public function subscribe(): void
    {
        $this->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        Subscriber::query()->updateOrCreate(
            ['email' => strtolower($this->email)],
            ['is_active' => true],
        );

        $this->subscribed = true;
        $this->reset('email');
    }

    public function render()
    {
        return view('livewire.newsletter-subscribe');
    }
}
