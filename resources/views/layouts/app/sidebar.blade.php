<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky collapsible
        class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <div class="px-3 text-xs font-semibold text-zinc-400 dark:text-zinc-500 in-data-flux-sidebar-collapsed-desktop:hidden mt-2 mb-1">{{ __('Community') }}</div>
            
            <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                wire:navigate>
                {{ __('Dashboard') }}
            </flux:sidebar.item>

            <flux:sidebar.item icon="chat-bubble-left-right" :href="route('home')" :current="request()->routeIs('home')"
                wire:navigate>
                {{ __('Explore') }}
            </flux:sidebar.item>

            <flux:sidebar.item icon="bookmark" :href="route('saved')" :current="request()->routeIs('saved')"
                wire:navigate>
                {{ __('Saved Posts') }}
            </flux:sidebar.item>

            <div class="px-3 text-xs font-semibold text-zinc-400 dark:text-zinc-500 in-data-flux-sidebar-collapsed-desktop:hidden mt-6 mb-1">{{ __('Personal') }}</div>
            
            <flux:sidebar.item icon="flag" :href="route('goals')" :current="request()->routeIs('goals')"
                wire:navigate>
                {{ __('My Goals') }}
            </flux:sidebar.item>

            <flux:sidebar.item icon="bell" :href="route('notifications')" :current="request()->routeIs('notifications')"
                wire:navigate>
                {{ __('Notifications') }}
            </flux:sidebar.item>

            @if(auth()->user()?->isAdmin())
                <div class="px-3 text-xs font-semibold text-zinc-400 dark:text-zinc-500 in-data-flux-sidebar-collapsed-desktop:hidden mt-6 mb-1">{{ __('Admin Panel') }}</div>
                
                <flux:sidebar.item icon="squares-2x2" :href="route('admin.posts.index')"
                    :current="request()->routeIs('admin.posts.index')" wire:navigate>
                    {{ __('All Posts') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="plus-circle" :href="route('admin.posts.create')"
                    :current="request()->routeIs('admin.posts.create')" wire:navigate>
                    {{ __('Create Post') }}
                </flux:sidebar.item>
            @endif
        </flux:sidebar.nav>

        <flux:spacer />

        <flux:sidebar.nav>
            <flux:sidebar.item icon="cog-6-tooth" :href="route('profile.edit')" :current="request()->routeIs('profile.*')" wire:navigate>
                {{ __('Settings') }}
            </flux:sidebar.item>
        </flux:sidebar.nav>

        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer" data-test="logout-button">
                        {{ __('Log out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    <flux:main container>
        <div class="py-6 px-4">
            {{ $slot }}
        </div>
    </flux:main>

    @fluxScripts
</body>

</html>