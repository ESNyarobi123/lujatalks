<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#FDFCFA] dark:bg-zinc-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} - Luja Talks</title>
    <x-luja-favicon />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-[#FDFCFA] dark:bg-zinc-900">

    {{-- Left Sidebar --}}
    <flux:sidebar sticky stashable collapsible class="bg-[#FDFCFA] border-r border-[#BC6C25]/15 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <div class="flex items-center gap-2 mb-6 mt-2 px-2 w-full">
            <x-luja-mark size="sidebar" class="shrink-0" />
            <div class="flex flex-col min-w-0 flex-1">
                <span class="text-lg font-black tracking-tight text-zinc-900 truncate leading-tight">Luja Talks</span>
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Admin</span>
            </div>
            <flux:sidebar.collapse class="hidden lg:flex" />
        </div>

        <flux:sidebar.nav variant="outline">
            <flux:sidebar.item href="{{ route('admin.dashboard') }}" icon="chart-bar" :current="request()->routeIs('admin.dashboard')">Dashboard</flux:sidebar.item>
            
            <div class="mt-4 px-3 text-xs font-semibold text-zinc-400 in-data-flux-sidebar-collapsed-desktop:hidden">Content</div>
            <flux:sidebar.item href="{{ route('admin.posts.index') }}" icon="document-text" :current="request()->routeIs('admin.posts.*')">Posts</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('admin.videos.index') }}" icon="play-circle" :current="request()->routeIs('admin.videos.*')">Videos</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('admin.quotes.index') }}" icon="sparkles" :current="request()->routeIs('admin.quotes.*')">Daily Quotes</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('admin.categories.index') }}" icon="folder" :current="request()->routeIs('admin.categories.*')">Categories</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('admin.tags.index') }}" icon="hashtag" :current="request()->routeIs('admin.tags.*')">Tags</flux:sidebar.item>

            <div class="mt-4 px-3 text-xs font-semibold text-zinc-400 in-data-flux-sidebar-collapsed-desktop:hidden">Community</div>
            <flux:sidebar.item href="{{ route('admin.users.index') }}" icon="users" :current="request()->routeIs('admin.users.*')">Users</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('admin.comments.index') }}" icon="chat-bubble-left-ellipsis" :current="request()->routeIs('admin.comments.*')">Comments</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('admin.reports.index') }}" icon="flag" :current="request()->routeIs('admin.reports.*')">Reported Content</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('admin.subscribers.index') }}" icon="envelope" :current="request()->routeIs('admin.subscribers.*')">Subscribers</flux:sidebar.item>

            <div class="mt-4 px-3 text-xs font-semibold text-zinc-400 in-data-flux-sidebar-collapsed-desktop:hidden">Platform</div>
            <flux:sidebar.item href="{{ route('admin.settings.media') }}" icon="photo" :current="request()->routeIs('admin.settings.media')">Media</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('admin.settings.homepage') }}" icon="view-columns" :current="request()->routeIs('admin.settings.homepage')">Homepage</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('admin.settings.roles') }}" icon="shield-check" :current="request()->routeIs('admin.settings.roles')">Roles</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('admin.settings.general') }}" icon="cog-6-tooth" :current="request()->routeIs('admin.settings.general')">Settings</flux:sidebar.item>
        </flux:sidebar.nav>

        <flux:spacer />

        <flux:sidebar.nav variant="outline">
            <flux:sidebar.item href="{{ route('home') }}" icon="arrow-top-right-on-square" target="_blank">View Live Site</flux:sidebar.item>
        </flux:sidebar.nav>
    </flux:sidebar>

    {{-- Top Header --}}
    <flux:header class="border-b border-[#BC6C25]/20 bg-white shadow-sm shadow-[#BC6C25]/5">
        <flux:sidebar.toggle class="lg:hidden mr-4" icon="bars-2" />

        <div class="flex items-center justify-between w-full gap-4">
            <div class="flex items-center gap-2 flex-1 min-w-0">
                <livewire:admin.quick-search />
            </div>

            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                <livewire:admin.header-alerts />

                <flux:separator vertical class="h-6 mx-2" />

                <flux:dropdown position="bottom" align="end">
                    <flux:button variant="ghost" class="!px-2 h-10">
                        <div
                            class="h-8 w-8 rounded-full bg-zinc-800 text-white flex items-center justify-center font-bold text-xs ring-2 ring-zinc-200">
                            {{ auth()->user()->initials() }}
                        </div>
                        <span class="hidden lg:flex lg:items-center ml-2">
                            <span class="text-sm font-semibold leading-6 text-zinc-900"
                                aria-hidden="true">{{ auth()->user()->name }}</span>
                            <flux:icon.chevron-down class="ml-2 h-4 w-4 text-zinc-400" />
                        </span>
                    </flux:button>
                    <flux:menu class="min-w-[200px]">
                        <div class="px-3 py-2 border-b border-zinc-100">
                            <p class="text-xs text-zinc-500">Signed in as</p>
                            <p class="font-bold text-sm text-zinc-900 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <flux:menu.item href="{{ route('dashboard') }}" icon="user">My Profile</flux:menu.item>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                class="w-full">Sign out</flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </div>
    </flux:header>

    {{-- Main Content --}}
    <flux:main container>
        <div class="py-6">
            {{ $slot }}
        </div>
    </flux:main>

    <flux:toast />
    @fluxScripts
</body>

</html>