<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(! empty($metaDescription ?? null))
        <meta name="description" content="{{ e($metaDescription) }}">
    @else
        <meta name="description" content="Luja Talks — Personal Growth & Inspiration Platform for ambitious youth. Articles, videos, goals, and community.">
    @endif
    <title>{{ $title ?? config('app.name', 'Luja Talks') }}</title>
    <x-luja-favicon />
    @if(! empty($ogTitle ?? null))
        <meta property="og:title" content="{{ e($ogTitle) }}">
        <meta property="og:type" content="article">
        <meta property="og:description" content="{{ e($ogDescription ?? $metaDescription ?? '') }}">
        <meta property="og:url" content="{{ e($ogUrl ?? url()->current()) }}">
        @if(! empty($ogImage ?? null))
            <meta property="og:image" content="{{ e($ogImage) }}">
        @endif
        <meta name="twitter:card" content="summary_large_image">
    @endif
    <link rel="canonical" href="{{ e($canonicalUrl ?? url()->current()) }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#EEEBD9] min-h-screen flex flex-col font-sans antialiased text-[#282427]"
    x-data="{ mobileMenuOpen: false }"
    style="background-color: #EEEBD9;">

    {{-- Sticky Navigation --}}
    <header
        class="sticky top-0 z-50 w-full backdrop-blur-xl bg-[#EEEBD9]/90 border-b border-[#282427]/10 transition-all duration-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 sm:h-20 flex items-center justify-between">
            {{-- Logo --}}
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 sm:gap-3 group flex-shrink-0">
                <x-luja-mark size="md" class="group-hover:-translate-y-0.5 transition-transform duration-300" />
                <span class="text-xl sm:text-2xl font-black tracking-tight text-[#282427]"><span
                        class="text-[#BC6C25]">Luja</span>Talks.</span>
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden lg:flex items-center gap-0.5 font-medium text-[14px] xl:text-[15px]">
                <a href="{{ route('home') }}" wire:navigate
                    class="px-3 xl:px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('home') ? 'text-[#BC6C25] bg-[#BC6C25]/10 font-bold' : 'text-[#282427]/70 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5' }}">Home</a>
                <a href="{{ route('explore') }}" wire:navigate
                    class="px-3 xl:px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('explore') ? 'text-[#BC6C25] bg-[#BC6C25]/10 font-bold' : 'text-[#282427]/70 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5' }}">Explore</a>
                <flux:dropdown position="bottom" align="start" class="hidden lg:block">
                    <flux:button variant="ghost" size="sm" class="!rounded-xl !px-3 xl:!px-4 !py-2 !h-auto !font-medium {{ request()->routeIs('categories.*') ? '!text-[#BC6C25] !bg-[#BC6C25]/10 !font-bold' : '!text-[#282427]/70 hover:!text-[#BC6C25]' }}">
                        Categories
                        <flux:icon.chevron-down class="w-4 h-4 opacity-60" />
                    </flux:button>
                    <flux:menu class="max-h-80 overflow-y-auto min-w-[200px]">
                        @forelse($navCategories ?? [] as $cat)
                            <flux:menu.item href="{{ route('categories.show', $cat['slug']) }}" wire:navigate>{{ $cat['name'] }}</flux:menu.item>
                        @empty
                            <flux:menu.item disabled>No categories yet</flux:menu.item>
                        @endforelse
                        <flux:menu.separator />
                        <flux:menu.item href="{{ route('categories.index') }}" wire:navigate icon="squares-2x2">All categories</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
                <a href="{{ route('videos') }}" wire:navigate
                    class="px-3 xl:px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('videos') ? 'text-[#BC6C25] bg-[#BC6C25]/10 font-bold' : 'text-[#282427]/70 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5' }}">Videos</a>
                <a href="{{ route('community') }}" wire:navigate
                    class="px-3 xl:px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('community') ? 'text-[#BC6C25] bg-[#BC6C25]/10 font-bold' : 'text-[#282427]/70 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5' }}">Community</a>
                <a href="{{ route('about') }}" wire:navigate
                    class="px-3 xl:px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('about') ? 'text-[#BC6C25] bg-[#BC6C25]/10 font-bold' : 'text-[#282427]/70 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5' }}">About</a>
                @auth
                    <a href="{{ route('dashboard') }}" wire:navigate
                        class="px-3 xl:px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('dashboard') || request()->routeIs('saved') || request()->routeIs('goals') ? 'text-[#BC6C25] bg-[#BC6C25]/10 font-bold' : 'text-[#282427]/70 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5' }}">My Space</a>
                    <a href="{{ route('missions') }}" wire:navigate
                        class="px-3 xl:px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('missions') ? 'text-[#BC6C25] bg-[#BC6C25]/10 font-bold' : 'text-[#282427]/70 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5' }}">Missions</a>
                @endauth
            </nav>

            {{-- Actions --}}
            <div class="flex items-center gap-2 sm:gap-3">
                {{-- Search --}}
                <a href="{{ route('search') }}"
                    class="w-10 h-10 rounded-xl flex items-center justify-center text-[#282427]/60 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5 transition-colors">
                    <flux:icon.magnifying-glass class="w-5 h-5" />
                </a>

                @auth
                    {{-- Notifications --}}
                    <a href="{{ route('notifications') }}"
                        class="relative w-10 h-10 rounded-xl flex items-center justify-center text-[#282427]/60 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5 transition-colors">
                        <flux:icon.bell class="w-5 h-5" />
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-[#BC6C25] rounded-full ring-2 ring-[#EEEBD9]"></span>
                        @endif
                    </a>

                    {{-- User Menu --}}
                    <flux:dropdown position="bottom" align="end">
                        <flux:button variant="ghost" class="!p-0 !rounded-full">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#282427] text-white flex items-center justify-center font-bold text-sm ring-2 ring-[#282427]/10">
                                {{ auth()->user()->initials() }}
                            </div>
                        </flux:button>
                        <flux:menu class="min-w-[200px]">
                            <div class="px-3 py-2 border-b border-zinc-100">
                                <p class="font-bold text-sm text-zinc-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-zinc-500">{{ auth()->user()->email }}</p>
                            </div>
                            <flux:menu.item href="{{ route('dashboard') }}" icon="home" wire:navigate>My Space</flux:menu.item>
                            <flux:menu.item href="{{ route('missions') }}" icon="map" wire:navigate>Mission paths</flux:menu.item>
                            <flux:menu.item href="{{ route('saved') }}" icon="bookmark" wire:navigate>Saved Posts</flux:menu.item>
                            <flux:menu.item href="{{ route('goals') }}" icon="flag" wire:navigate>My Goals</flux:menu.item>
                            <flux:menu.item href="{{ route('profile.edit') }}" icon="cog-6-tooth" wire:navigate>Settings</flux:menu.item>
                            @if(auth()->user()->isAdmin())
                                <flux:menu.separator />
                                <flux:menu.item href="{{ route('admin.posts.index') }}" icon="squares-2x2" wire:navigate>Admin Panel</flux:menu.item>
                            @endif
                            <flux:menu.separator />
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">Log Out</flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                @else
                    <a href="{{ route('login') }}"
                        class="hidden sm:block font-bold text-[#282427] hover:text-[#BC6C25] px-4 transition-colors">Log In</a>
                    <a href="{{ route('register') }}"
                        class="bg-[#BC6C25] text-white rounded-full px-5 sm:px-7 py-2 sm:py-2.5 font-bold text-sm sm:text-[15px] shadow-xl shadow-[#BC6C25]/40 hover:-translate-y-0.5 hover:shadow-2xl transition-all border-b-2 border-[#A65D1F]">Join
                        Now</a>
                @endauth

                {{-- Mobile Menu Toggle --}}
                <button @click="mobileMenuOpen = true"
                    class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center text-[#282427]/70 hover:bg-[#282427]/5 transition-colors">
                    <flux:icon.bars-3 class="w-6 h-6" />
                </button>
            </div>
        </div>
    </header>

    {{-- Mobile Menu Overlay --}}
    <div x-show="mobileMenuOpen" 
         x-transition.opacity.duration.300ms
         @click="mobileMenuOpen = false"
         class="fixed inset-0 z-[60] bg-[#282427]/40 backdrop-blur-sm lg:hidden" x-cloak>
    </div>

    {{-- Mobile Menu Sidebar (Left) --}}
    <div x-show="mobileMenuOpen"
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed top-0 left-0 bottom-0 z-[70] w-4/5 max-w-sm bg-[#EEEBD9] shadow-2xl flex flex-col lg:hidden border-r border-[#282427]/10" x-cloak>
         
        {{-- Sidebar Header --}}
        <div class="px-6 h-16 sm:h-20 flex items-center justify-between border-b border-[#282427]/5 shrink-0 bg-white/40">
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 group">
                <x-luja-mark size="sm" class="group-hover:-translate-y-0.5 transition-transform duration-300" />
                <span class="text-xl font-black tracking-tight text-[#282427]">LujaTalks</span>
            </a>
            <button @click="mobileMenuOpen = false" class="w-10 h-10 rounded-xl flex items-center justify-center text-[#282427]/50 hover:bg-[#282427]/5 hover:text-[#282427] transition-colors">
                <flux:icon.x-mark class="w-6 h-6" />
            </button>
        </div>

        {{-- Sidebar Content --}}
        <div class="flex-1 overflow-y-auto py-6 px-4">
            <nav class="flex flex-col gap-2">
                <h3 class="text-xs font-bold uppercase tracking-widest text-[#282427]/40 px-3 mb-2">Discover</h3>
                
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                    class="px-4 py-3 rounded-2xl font-bold flex items-center gap-3 transition-colors {{ request()->routeIs('home') ? 'text-[#BC6C25] bg-[#BC6C25]/10 shadow-sm' : 'text-[#282427]/70 hover:bg-[#282427]/5' }}">
                    <flux:icon.home class="w-5 h-5 {{ request()->routeIs('home') ? '' : 'opacity-60' }}" />
                    Home
                </a>
                <a href="{{ route('explore') }}" @click="mobileMenuOpen = false"
                    class="px-4 py-3 rounded-2xl font-bold flex items-center gap-3 transition-colors {{ request()->routeIs('explore') ? 'text-[#BC6C25] bg-[#BC6C25]/10 shadow-sm' : 'text-[#282427]/70 hover:bg-[#282427]/5' }}">
                    <flux:icon.globe-alt class="w-5 h-5 {{ request()->routeIs('explore') ? '' : 'opacity-60' }}" />
                    Explore Feed
                </a>
                <a href="{{ route('videos') }}" @click="mobileMenuOpen = false"
                    class="px-4 py-3 rounded-2xl font-bold flex items-center gap-3 transition-colors {{ request()->routeIs('videos') ? 'text-[#BC6C25] bg-[#BC6C25]/10 shadow-sm' : 'text-[#282427]/70 hover:bg-[#282427]/5' }}">
                    <flux:icon.play-circle class="w-5 h-5 {{ request()->routeIs('videos') ? '' : 'opacity-60' }}" />
                    Video Library
                </a>
                <a href="{{ route('categories.index') }}" @click="mobileMenuOpen = false"
                    class="px-4 py-3 rounded-2xl font-bold flex items-center gap-3 transition-colors {{ request()->routeIs('categories.index') ? 'text-[#BC6C25] bg-[#BC6C25]/10 shadow-sm' : 'text-[#282427]/70 hover:bg-[#282427]/5' }}">
                    <flux:icon.squares-2x2 class="w-5 h-5 opacity-60" />
                    Categories
                </a>
                <a href="{{ route('community') }}" @click="mobileMenuOpen = false"
                    class="px-4 py-3 rounded-2xl font-bold flex items-center gap-3 transition-colors {{ request()->routeIs('community') ? 'text-[#BC6C25] bg-[#BC6C25]/10 shadow-sm' : 'text-[#282427]/70 hover:bg-[#282427]/5' }}">
                    <flux:icon.chat-bubble-left-right class="w-5 h-5 opacity-60" />
                    Community
                </a>
                <a href="{{ route('about') }}" @click="mobileMenuOpen = false"
                    class="px-4 py-3 rounded-2xl font-bold flex items-center gap-3 transition-colors {{ request()->routeIs('about') ? 'text-[#BC6C25] bg-[#BC6C25]/10 shadow-sm' : 'text-[#282427]/70 hover:bg-[#282427]/5' }}">
                    <flux:icon.information-circle class="w-5 h-5 opacity-60" />
                    About
                </a>

                @auth
                    <h3 class="text-xs font-bold uppercase tracking-widest text-[#282427]/40 px-3 mt-6 mb-2">My Journey</h3>
                    
                    <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false"
                        class="px-4 py-3 rounded-2xl font-bold flex items-center gap-3 transition-colors {{ request()->routeIs('dashboard') ? 'text-[#BC6C25] bg-[#BC6C25]/10 shadow-sm' : 'text-[#282427]/70 hover:bg-[#282427]/5' }}">
                        <flux:icon.squares-2x2 class="w-5 h-5 {{ request()->routeIs('dashboard') ? '' : 'opacity-60' }}" />
                        My Space
                    </a>
                    <a href="{{ route('missions') }}" @click="mobileMenuOpen = false"
                        class="px-4 py-3 rounded-2xl font-bold flex items-center gap-3 transition-colors {{ request()->routeIs('missions') ? 'text-[#BC6C25] bg-[#BC6C25]/10 shadow-sm' : 'text-[#282427]/70 hover:bg-[#282427]/5' }}">
                        <flux:icon.map class="w-5 h-5 {{ request()->routeIs('missions') ? '' : 'opacity-60' }}" />
                        Mission paths
                    </a>
                    <a href="{{ route('saved') }}" @click="mobileMenuOpen = false"
                        class="px-4 py-3 rounded-2xl font-bold flex items-center gap-3 transition-colors {{ request()->routeIs('saved') ? 'text-[#BC6C25] bg-[#BC6C25]/10 shadow-sm' : 'text-[#282427]/70 hover:bg-[#282427]/5' }}">
                        <flux:icon.bookmark class="w-5 h-5 {{ request()->routeIs('saved') ? '' : 'opacity-60' }}" />
                        Saved Posts
                    </a>
                    <a href="{{ route('goals') }}" @click="mobileMenuOpen = false"
                        class="px-4 py-3 rounded-2xl font-bold flex items-center gap-3 transition-colors {{ request()->routeIs('goals') ? 'text-[#BC6C25] bg-[#BC6C25]/10 shadow-sm' : 'text-[#282427]/70 hover:bg-[#282427]/5' }}">
                        <flux:icon.flag class="w-5 h-5 {{ request()->routeIs('goals') ? '' : 'opacity-60' }}" />
                        My Goals
                    </a>
                @else
                    <div class="mt-8 pt-6 border-t border-[#282427]/10 flex flex-col gap-3 px-2">
                        <p class="text-sm text-[#282427]/60 text-center mb-2 px-2">Join to unlock your personal growth dashboard.</p>
                        <a href="{{ route('login') }}" class="w-full py-3 rounded-full font-bold text-center border border-[#282427]/10 text-[#282427] hover:bg-white transition-colors bg-white/50">Log In</a>
                        <a href="{{ route('register') }}" class="w-full py-3 rounded-full font-bold text-center bg-[#BC6C25] text-white shadow-lg shadow-[#BC6C25]/30">Create Account</a>
                    </div>
                @endauth
            </nav>
        </div>
        
        @auth
            {{-- User Bottom Section --}}
            <div class="p-4 border-t border-[#282427]/10 bg-white/50 mt-auto">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="w-10 h-10 rounded-full bg-[#282427] text-white flex items-center justify-center font-bold text-sm ring-2 ring-[#282427]/10 flex-shrink-0">
                        {{ auth()->user()->initials() }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-sm text-[#282427] truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#282427]/50 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl font-bold text-sm text-red-500 hover:bg-red-50 transition-colors">
                        <flux:icon.arrow-right-start-on-rectangle class="w-5 h-5" />
                        Log Out
                    </button>
                </form>
            </div>
        @endauth
    </div>

    {{-- Main Content --}}
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer
        class="bg-[#282427] text-[#EEEBD9] pt-16 sm:pt-24 pb-8 sm:pb-12 border-t-[6px] border-[#BC6C25] mt-12 sm:mt-20 rounded-t-[24px] sm:rounded-t-[40px] shadow-[0_-20px_40px_rgba(0,0,0,0.1)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 sm:gap-12 mb-12 sm:mb-16">
                <div class="sm:col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-6 sm:mb-8">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-[#BC6C25] text-white flex items-center justify-center font-bold text-xl sm:text-2xl shadow-lg shadow-[#BC6C25]/40">
                            L</div>
                        <span class="text-2xl sm:text-[28px] font-black tracking-tight text-[#EEEBD9]"><span
                                class="text-[#BC6C25]">Luja</span>Talks.</span>
                    </a>
                    <p class="max-w-md text-[#EEEBD9]/80 leading-loose text-[15px]">
                        Platform namba moja kwa vijana kujifunza, kujiwekea malengo, na kupata inspiration ya kila siku
                        kuelekea mafanikio ya kweli.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-bold text-lg mb-4 sm:mb-6 uppercase tracking-wider">Explore</h4>
                    <ul class="space-y-3 sm:space-y-4 text-[15px] font-medium">
                        <li><a href="{{ route('explore') }}" class="text-[#EEEBD9]/70 hover:text-[#BC6C25] transition-colors">Explore articles</a></li>
                        <li><a href="{{ route('categories.index') }}" class="text-[#EEEBD9]/70 hover:text-[#BC6C25] transition-colors">Categories</a></li>
                        <li><a href="{{ route('videos') }}" class="text-[#EEEBD9]/70 hover:text-[#BC6C25] transition-colors">Videos</a></li>
                        <li><a href="{{ route('community') }}" class="text-[#EEEBD9]/70 hover:text-[#BC6C25] transition-colors">Community</a></li>
                        @auth
                            <li><a href="{{ route('goals') }}" class="text-[#EEEBD9]/70 hover:text-[#BC6C25] transition-colors">My goals</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold text-lg mb-4 sm:mb-6 uppercase tracking-wider">Connect</h4>
                    <ul class="space-y-3 sm:space-y-4 text-[15px] font-medium">
                        <li><a href="{{ route('about') }}" class="text-[#EEEBD9]/70 hover:text-[#BC6C25] transition-colors">About Luja Talks</a></li>
                        <li><a href="{{ route('about') }}#contact" class="text-[#EEEBD9]/70 hover:text-[#BC6C25] transition-colors">Contact</a></li>
                        <li><a href="{{ route('register') }}" class="text-[#EEEBD9]/70 hover:text-[#BC6C25] transition-colors">Join the community</a></li>
                    </ul>
                </div>
            </div>
            <div
                class="pt-6 sm:pt-8 border-t border-[#EEEBD9]/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-[#EEEBD9]/50 font-medium">
                <p>&copy; {{ date('Y') }} Luja Talks. All rights reserved.</p>
                <div class="flex gap-6 sm:gap-8">
                    <a href="{{ route('about') }}#privacy" class="hover:text-[#EEEBD9] transition-colors">Privacy &amp; terms</a>
                </div>
            </div>
        </div>
    </footer>

    @fluxScripts
</body>

</html>