<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use Laravel\Socialite\Two\InvalidStateException;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Send the user to Google's OAuth consent screen.
     */
    public function redirect(): RedirectResponse|SymfonyRedirectResponse
    {
        if (! $this->googleOAuthReady()) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('Google sign-in is not configured.')]);
        }

        return $this->socialite()->driver('google')->redirect();
    }

    /**
     * Handle the OAuth callback from Google (login or register).
     */
    public function callback(Request $request): RedirectResponse
    {
        if (! $this->googleOAuthReady()) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('Google sign-in is not configured.')]);
        }

        try {
            $googleUser = $this->socialite()->driver('google')->user();
        } catch (InvalidStateException) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('Your Google sign-in session expired. Please try again.')]);
        } catch (Throwable) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('Unable to sign in with Google. Please try again.')]);
        }

        $emailRaw = $googleUser->getEmail();
        if (! is_string($emailRaw) || $emailRaw === '') {
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('Google did not provide an email address.')]);
        }

        $email = Str::lower(trim($emailRaw));
        $googleId = (string) $googleUser->getId();

        $user = User::query()->where('google_id', $googleId)->first()
            ?? User::query()->where('email', $email)->first();

        if ($user !== null) {
            if ($user->google_id === null) {
                $user->forceFill([
                    'google_id' => $googleId,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ])->save();
            } elseif ($user->google_id !== $googleId) {
                return redirect()
                    ->route('login')
                    ->withErrors(['email' => __('This email is already linked to a different sign-in method.')]);
            }
        } else {
            $name = $googleUser->getName();
            if (! is_string($name) || trim($name) === '') {
                $name = Str::before($email, '@') ?: 'User';
            }

            $user = User::query()->create([
                'name' => $name,
                'email' => $email,
                'google_id' => $googleId,
                'password' => Hash::make(Str::password(64)),
            ]);
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Socialite must be installed (composer) and OAuth env vars must be set.
     */
    private function googleOAuthReady(): bool
    {
        if (! interface_exists(SocialiteFactory::class)) {
            return false;
        }

        if (! app()->bound(SocialiteFactory::class)) {
            return false;
        }

        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.redirect'));
    }

    private function socialite(): SocialiteFactory
    {
        return app(SocialiteFactory::class);
    }
}
