<x-layouts::auth :title="__('Log in')">
    {{-- Full page POST (no Livewire field components) so email/password always reach Fortify reliably. --}}
    <div class="flex flex-col gap-4 sm:gap-5">
        <x-auth-header
            :title="__('Log in to your account')"
            :description="__('Enter your email and password to continue')"
        />

        <x-auth-session-status class="text-center text-xs sm:text-sm" :status="session('status')" />

        <x-auth-google-button :label="__('Continue with Google')" class="py-2.5 text-xs font-bold sm:py-3 sm:text-sm" />

        <div class="relative flex items-center py-0.5">
            <div class="grow border-t border-[#282427]/10"></div>
            <span class="mx-3 shrink-0 text-[10px] font-bold uppercase tracking-wider text-[#282427]/40 sm:mx-4 sm:text-xs">{{ __('Or') }}</span>
            <div class="grow border-t border-[#282427]/10"></div>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-3.5 sm:gap-4">
            @csrf

            <div class="flex flex-col gap-1.5">
                <label for="login-email" class="text-xs font-bold text-[#282427] sm:text-sm">{{ __('Email address') }}</label>
                <input
                    id="login-email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="w-full rounded-lg border border-[#282427]/12 bg-white px-3 py-2 text-sm font-medium text-[#282427] shadow-sm placeholder:text-[#282427]/35 focus:border-[#BC6C25] focus:ring-2 focus:ring-[#BC6C25]/25 sm:px-3.5 sm:py-2.5"
                />
                @error('email')
                    <p class="text-xs font-semibold text-red-600 sm:text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative flex flex-col gap-1.5">
                <label for="login-password" class="text-xs font-bold text-[#282427] sm:text-sm">{{ __('Password') }}</label>
                <input
                    id="login-password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="{{ __('Password') }}"
                    class="w-full rounded-lg border border-[#282427]/12 bg-white px-3 py-2 text-sm font-medium text-[#282427] shadow-sm placeholder:text-[#282427]/35 focus:border-[#BC6C25] focus:ring-2 focus:ring-[#BC6C25]/25 sm:px-3.5 sm:py-2.5"
                />
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="absolute end-0 top-0 max-w-[45%] truncate text-end text-[11px] font-bold leading-tight text-[#BC6C25] hover:underline sm:max-w-none sm:text-xs">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <label class="flex cursor-pointer items-center gap-2">
                <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="size-3.5 rounded border-[#282427]/25 text-[#BC6C25] focus:ring-[#BC6C25]/30 sm:size-4" />
                <span class="text-xs font-semibold text-[#282427]/80 sm:text-sm">{{ __('Remember me') }}</span>
            </label>

            <button type="submit" class="w-full cursor-pointer rounded-full border-0 bg-[#BC6C25] py-2.5 text-sm font-black text-white shadow-lg shadow-[#BC6C25]/35 transition-all hover:bg-[#a65d1f] sm:py-3 sm:text-base" data-test="login-button">
                {{ __('Log in') }}
            </button>
        </form>

        @if (Route::has('register'))
            <p class="border-t border-[#282427]/8 pt-3 text-center text-xs text-[#282427]/60 sm:pt-4 sm:text-sm">
                <span>{{ __('No account yet?') }}</span>
                <a href="{{ route('register') }}" class="ms-1 font-bold text-[#BC6C25] underline-offset-2 hover:underline">{{ __('Sign up') }}</a>
            </p>
        @endif
    </div>
</x-layouts::auth>
