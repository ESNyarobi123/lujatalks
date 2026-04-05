<x-layouts::auth :title="__('Log in')">
    {{-- Full page POST (no Livewire field components) so email/password always reach Fortify reliably. --}}
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <x-auth-google-button :label="__('Continue with Google')" class="font-black" />

        <div class="relative flex items-center py-1">
            <div class="grow border-t border-[#282427]/10"></div>
            <span class="mx-4 shrink-0 text-xs font-bold uppercase tracking-wider text-[#282427]/45">{{ __('Or') }}</span>
            <div class="grow border-t border-[#282427]/10"></div>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="login-email" class="text-sm font-bold text-[#282427]">{{ __('Email address') }}</label>
                <input
                    id="login-email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="w-full px-4 py-3 rounded-xl border border-[#282427]/15 bg-white text-[#282427] placeholder:text-[#282427]/40 focus:ring-2 focus:ring-[#BC6C25]/30 focus:border-[#BC6C25] text-sm font-medium shadow-sm"
                />
                @error('email')
                    <p class="text-sm font-bold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-2 relative">
                <label for="login-password" class="text-sm font-bold text-[#282427]">{{ __('Password') }}</label>
                <input
                    id="login-password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="{{ __('Password') }}"
                    class="w-full px-4 py-3 rounded-xl border border-[#282427]/15 bg-white text-[#282427] placeholder:text-[#282427]/40 focus:ring-2 focus:ring-[#BC6C25]/30 focus:border-[#BC6C25] text-sm font-medium shadow-sm"
                />
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="absolute top-0 end-0 text-sm font-bold text-[#BC6C25] hover:underline">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="rounded border-[#282427]/25 text-[#BC6C25] focus:ring-[#BC6C25]/30" />
                <span class="text-sm font-bold text-[#282427]">{{ __('Remember me') }}</span>
            </label>

            <button type="submit" class="w-full py-4 rounded-full font-black text-base text-white bg-[#BC6C25] shadow-lg shadow-[#BC6C25]/40 hover:bg-[#a65d1f] transition-all border-0 cursor-pointer" data-test="login-button">
                {{ __('Log in') }}
            </button>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('Don\'t have an account?') }}</span>
                <a href="{{ route('register') }}" class="font-bold text-[#BC6C25] hover:underline">{{ __('Sign up') }}</a>
            </div>
        @endif
    </div>
</x-layouts::auth>
