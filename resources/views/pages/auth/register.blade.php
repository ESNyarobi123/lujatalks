<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-4 sm:gap-5">
        <x-auth-header
            :title="__('Create an account')"
            :description="__('Join with email or Google — it only takes a moment')"
        />

        <x-auth-session-status class="text-center text-xs sm:text-sm" :status="session('status')" />

        <x-auth-google-button :label="__('Sign up with Google')" class="py-2.5 text-xs font-bold sm:py-3 sm:text-sm" />

        <div class="relative flex items-center py-0.5">
            <div class="grow border-t border-[#282427]/10"></div>
            <span class="mx-3 shrink-0 text-[10px] font-bold uppercase tracking-wider text-[#282427]/40 sm:mx-4 sm:text-xs">{{ __('Or') }}</span>
            <div class="grow border-t border-[#282427]/10"></div>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-3.5 sm:gap-4">
            @csrf

            <div class="flex flex-col gap-1.5">
                <label for="register-name" class="text-xs font-bold text-[#282427] sm:text-sm">{{ __('Name') }}</label>
                <input
                    id="register-name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="{{ __('Full name') }}"
                    class="w-full rounded-lg border border-[#282427]/12 bg-white px-3 py-2 text-sm font-medium text-[#282427] shadow-sm placeholder:text-[#282427]/35 focus:border-[#BC6C25] focus:ring-2 focus:ring-[#BC6C25]/25 sm:px-3.5 sm:py-2.5"
                />
                @error('name')
                    <p class="text-xs font-semibold text-red-600 sm:text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="register-email" class="text-xs font-bold text-[#282427] sm:text-sm">{{ __('Email address') }}</label>
                <input
                    id="register-email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="w-full rounded-lg border border-[#282427]/12 bg-white px-3 py-2 text-sm font-medium text-[#282427] shadow-sm placeholder:text-[#282427]/35 focus:border-[#BC6C25] focus:ring-2 focus:ring-[#BC6C25]/25 sm:px-3.5 sm:py-2.5"
                />
                @error('email')
                    <p class="text-xs font-semibold text-red-600 sm:text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="register-password" class="text-xs font-bold text-[#282427] sm:text-sm">{{ __('Password') }}</label>
                <input
                    id="register-password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('Password') }}"
                    class="w-full rounded-lg border border-[#282427]/12 bg-white px-3 py-2 text-sm font-medium text-[#282427] shadow-sm placeholder:text-[#282427]/35 focus:border-[#BC6C25] focus:ring-2 focus:ring-[#BC6C25]/25 sm:px-3.5 sm:py-2.5"
                />
                @error('password')
                    <p class="text-xs font-semibold text-red-600 sm:text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="register-password-confirmation" class="text-xs font-bold text-[#282427] sm:text-sm">{{ __('Confirm password') }}</label>
                <input
                    id="register-password-confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('Confirm password') }}"
                    class="w-full rounded-lg border border-[#282427]/12 bg-white px-3 py-2 text-sm font-medium text-[#282427] shadow-sm placeholder:text-[#282427]/35 focus:border-[#BC6C25] focus:ring-2 focus:ring-[#BC6C25]/25 sm:px-3.5 sm:py-2.5"
                />
            </div>

            <button type="submit" class="w-full cursor-pointer rounded-full border-0 bg-[#BC6C25] py-2.5 text-sm font-black text-white shadow-lg shadow-[#BC6C25]/35 transition-all hover:bg-[#a65d1f] sm:py-3 sm:text-base" data-test="register-user-button">
                {{ __('Create account') }}
            </button>
        </form>

        <p class="border-t border-[#282427]/8 pt-3 text-center text-xs text-[#282427]/60 sm:pt-4 sm:text-sm">
            <span>{{ __('Already have an account?') }}</span>
            <a href="{{ route('login') }}" class="ms-1 font-bold text-[#BC6C25] underline-offset-2 hover:underline">{{ __('Sign in') }}</a>
        </p>
    </div>
</x-layouts::auth>
