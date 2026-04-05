<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as SocialiteGoogleUser;

uses(RefreshDatabase::class);

function configureGoogleForTests(): void
{
    config([
        'services.google.client_id' => 'test-google-client-id',
        'services.google.client_secret' => 'test-google-secret',
        'services.google.redirect' => 'http://localhost/auth/google/callback',
    ]);
}

test('google redirect sends user to login with error when not configured', function () {
    config([
        'services.google.client_id' => '',
        'services.google.client_secret' => '',
        'services.google.redirect' => '',
    ]);

    $this->get(route('auth.google.redirect'))
        ->assertRedirect(route('login', absolute: false))
        ->assertSessionHasErrors('email');
});

test('google redirect delegates to socialite when configured', function () {
    configureGoogleForTests();

    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('redirect')->once()->andReturn(
        redirect('https://accounts.google.com/o/oauth2/v2/auth?client=test')
    );

    Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

    $response = $this->get(route('auth.google.redirect'));

    $response->assertRedirect();
    expect($response->headers->get('Location'))->toContain('accounts.google.com');
});

test('google callback registers a new user and logs them in', function () {
    configureGoogleForTests();

    $socialUser = new SocialiteGoogleUser;
    $socialUser->id = 'gid-oauth-new';
    $socialUser->email = 'newgoogle@example.com';
    $socialUser->name = 'New Google User';

    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('user')->once()->andReturn($socialUser);

    Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

    $this->assertDatabaseMissing('users', ['email' => 'newgoogle@example.com']);

    $this->get(route('auth.google.callback'))
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();

    $user = User::query()->where('email', 'newgoogle@example.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->google_id)->toBe('gid-oauth-new')
        ->and($user->email_verified_at)->not->toBeNull();
});

test('google callback links google id to an existing email account', function () {
    configureGoogleForTests();

    $existing = User::factory()->create([
        'email' => 'existing@example.com',
        'google_id' => null,
    ]);

    $socialUser = new SocialiteGoogleUser;
    $socialUser->id = 'gid-linked';
    $socialUser->email = 'existing@example.com';
    $socialUser->name = 'Existing User';

    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('user')->once()->andReturn($socialUser);

    Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

    $this->get(route('auth.google.callback'))
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticatedAs($existing);

    expect($existing->refresh()->google_id)->toBe('gid-linked');
});

test('google callback redirects to login when oauth state is invalid', function () {
    configureGoogleForTests();

    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('user')->once()->andThrow(new InvalidStateException);

    Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

    $this->get(route('auth.google.callback'))
        ->assertRedirect(route('login', absolute: false))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('login page includes google auth link when google is configured', function () {
    configureGoogleForTests();

    $this->get(route('login'))
        ->assertOk()
        ->assertSee('/auth/google', false);
});

test('login page omits google auth link when google is not configured', function () {
    config([
        'services.google.client_id' => '',
        'services.google.client_secret' => '',
        'services.google.redirect' => '',
    ]);

    $this->get(route('login'))
        ->assertOk()
        ->assertDontSee('auth/google', false);
});
