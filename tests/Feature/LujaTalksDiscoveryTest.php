<?php

use App\Livewire\NewsletterSubscribe;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('renders the categories index page', function () {
    $this->get(route('categories.index'))->assertOk();
});

it('renders the community page', function () {
    $this->get(route('community'))->assertOk();
});

it('renders the about page', function () {
    $this->get(route('about'))->assertOk();
});

it('stores newsletter subscribers from the subscribe component', function () {
    Livewire::test(NewsletterSubscribe::class)
        ->set('email', 'reader@example.com')
        ->call('subscribe')
        ->assertSet('subscribed', true);

    expect(Subscriber::query()->where('email', 'reader@example.com')->exists())->toBeTrue();
});

it('validates newsletter email', function () {
    Livewire::test(NewsletterSubscribe::class)
        ->set('email', 'not-an-email')
        ->call('subscribe')
        ->assertHasErrors(['email']);
});

it('renders a public author profile by slug', function () {
    $user = User::factory()->create();

    expect($user->profile_slug)->not->toBeNull();

    $this->get(route('authors.show', $user->profile_slug))->assertOk();
});
