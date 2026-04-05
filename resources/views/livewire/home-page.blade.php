<div class="space-y-20 sm:space-y-24 pb-24 font-sans">

    {{-- 1. HERO SECTION --}}
    <section class="relative pt-12 pb-12 sm:pt-20 sm:pb-20 lg:pt-32 lg:pb-32 overflow-hidden px-4 sm:px-6 isolate">
        <div class="max-w-5xl mx-auto relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#BC6C25]/10 border border-[#BC6C25]/20 text-[#BC6C25] font-bold text-sm mb-6 sm:mb-8">
                <flux:icon.rocket-launch class="w-4 h-4" /> The Premiere Inspiration Hub
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-7xl lg:text-[80px] font-black leading-[1.05] tracking-tight mb-6 sm:mb-8 text-[#282427]">
                Grow Your Mind.<br>
                <span class="text-[#BC6C25]">Build Your Future.</span>
            </h1>

            <p class="text-lg sm:text-xl md:text-2xl font-medium text-[#282427]/70 max-w-2xl mb-8 sm:mb-12">
                Join the most exclusive community for ambitious youth to connect, learn, and elevate their lives through daily inspiration.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 w-full sm:w-auto">
                <a href="{{ route('explore') }}" class="w-full sm:w-auto bg-[#BC6C25] text-white rounded-full px-8 py-3.5 sm:py-4 font-bold text-[15px] sm:text-[16px] shadow-xl shadow-[#BC6C25]/30 hover:-translate-y-1 hover:shadow-2xl hover:shadow-[#BC6C25]/40 transition-all text-center border-b-2 border-[#A65D1F]">Explore Articles</a>
                <a href="{{ route('videos') }}" class="w-full sm:w-auto bg-white text-[#282427] border border-[#282427]/10 rounded-full px-8 py-3.5 sm:py-4 font-bold text-[15px] sm:text-[16px] hover:bg-[#282427]/5 hover:-translate-y-1 transition-all text-center flex items-center justify-center gap-2">
                    <flux:icon.play-circle class="w-5 h-5 text-[#BC6C25]" /> Watch Videos
                </a>
            </div>
        </div>

        {{-- Hero Gradients --}}
        <div class="absolute -top-40 -left-40 w-[400px] sm:w-[600px] h-[400px] sm:h-[600px] bg-[#BC6C25]/10 blur-[120px] rounded-full -z-10"></div>
        <div class="absolute top-20 -right-20 w-[300px] sm:w-[500px] h-[300px] sm:h-[500px] bg-[#282427]/5 blur-[100px] rounded-full -z-10"></div>
    </section>

    {{-- 2. DAILY MOTIVATION --}}
    @if($motivation)
    <section class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="relative bg-white rounded-3xl p-6 sm:p-8 md:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-[#282427]/5">
            <div class="absolute -top-4 -left-4 sm:-top-5 sm:-left-5 text-[#BC6C25] opacity-20">
                <svg class="w-16 h-16 sm:w-24 sm:h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
            </div>
            <div class="relative z-10">
                <h3 class="text-xs font-bold uppercase tracking-widest text-[#BC6C25] mb-4">Quote of the Day</h3>
                <p class="text-xl sm:text-2xl md:text-3xl font-black text-[#282427] leading-snug mb-4">"{{ $motivation->quote }}"</p>
                <p class="text-[15px] sm:text-[16px] font-bold text-[#282427]/60">— {{ $motivation->author ?? 'Anonymous' }}</p>
            </div>
        </div>
    </section>
    @endif

    {{-- 3. FEATURED CONTENT --}}
    @if($featuredPost)
    <section id="articles" class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between mb-8 sm:mb-10">
            <h2 class="text-2xl sm:text-3xl font-black text-[#282427]">Editor's Picks</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
            <a href="{{ route('posts.show', $featuredPost->slug) }}" class="group block lg:col-span-8 relative rounded-3xl overflow-hidden bg-[#282427] h-[300px] sm:h-[400px] lg:h-[500px]">
                @if($featuredPost->feature_image)
                    <img src="{{ $featuredPost->feature_image }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-50 transition-opacity duration-700 group-hover:scale-105" alt="{{ $featuredPost->title }}">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-[#282427] via-[#282427]/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 sm:p-8 md:p-12">
                    @if($featuredPost->category)
                        <span class="inline-block px-4 py-1.5 bg-[#BC6C25] text-white text-[13px] font-bold uppercase tracking-wider rounded-full mb-4 sm:mb-6 shadow-md">{{ $featuredPost->category->name }}</span>
                    @endif
                    <h3 class="text-2xl sm:text-3xl md:text-5xl font-black text-white leading-tight mb-3 sm:mb-4 group-hover:text-[#BC6C25] transition-colors drop-shadow-lg">{{ $featuredPost->title }}</h3>
                    <div class="flex items-center gap-3 sm:gap-4 text-white/80 text-sm font-medium">
                        <span class="flex items-center gap-2">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white/20 flex items-center justify-center font-bold text-white text-xs">{{ substr($featuredPost->user->name, 0, 1) }}</div>
                            {{ $featuredPost->user->name }}
                        </span>
                        <span>·</span>
                        <span>{{ $featuredPost->reading_time }} min read</span>
                    </div>
                </div>
            </a>

            @if($sidePosts && $sidePosts->count() > 0)
            <div class="lg:col-span-4 flex flex-col gap-6 sm:gap-8">
                @foreach($sidePosts as $sp)
                <a href="{{ route('posts.show', $sp->slug) }}" class="group flex flex-col h-full bg-white rounded-2xl p-5 sm:p-6 shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-[#282427]/5 hover:-translate-y-1 transition-transform">
                    <div class="flex-1">
                        @if($sp->category)
                            <span class="inline-block text-[#BC6C25] text-xs font-bold uppercase tracking-widest mb-3">{{ $sp->category->name }}</span>
                        @endif
                        <h3 class="text-lg sm:text-xl font-black text-[#282427] group-hover:text-[#BC6C25] transition-colors leading-snug line-clamp-3 mb-3 sm:mb-4">{{ $sp->title }}</h3>
                    </div>
                    <div class="flex items-center justify-between text-xs font-medium text-[#282427]/50 mt-auto">
                        <span>{{ $sp->user->name }}</span>
                        <span>{{ $sp->reading_time }} min read</span>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- 4. CATEGORIES --}}
    @if($categories && $categories->count() > 0)
    <section class="max-w-7xl mx-auto px-4 sm:px-6">
        <h2 class="text-2xl font-black text-[#282427] mb-6 sm:mb-8">Topics to Explore</h2>
        <div class="flex flex-wrap gap-3 sm:gap-4">
            @foreach($categories as $cat)
                <a href="{{ route('categories.show', $cat->slug) }}" class="px-5 sm:px-6 py-3 sm:py-4 bg-white rounded-2xl border border-[#282427]/5 shadow-sm hover:shadow-md hover:border-[#BC6C25]/30 transition-all flex items-center gap-3 group">
                    <span class="w-3 h-3 rounded-full bg-[#BC6C25] opacity-50 group-hover:opacity-100 transition-opacity"></span>
                    <span class="font-bold text-[#282427]">{{ $cat->name }}</span>
                    <span class="text-[#282427]/40 text-sm font-medium">({{ $cat->posts_count }})</span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- 5. VIDEO SECTION --}}
    @if($videos && $videos->count() > 0)
    <section id="videos" class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        <div class="bg-[#282427] rounded-3xl sm:rounded-[40px] p-6 sm:p-8 md:p-16 relative overflow-hidden shadow-2xl">
            <div class="absolute right-0 top-0 w-[300px] sm:w-[500px] h-[300px] sm:h-[500px] bg-[#BC6C25] blur-[150px] opacity-20 pointer-events-none"></div>
            <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between mb-8 sm:mb-12 relative z-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl md:text-5xl font-black text-white mb-3 sm:mb-4">Success on Screen</h2>
                    <p class="text-[#EEEBD9]/70 text-base sm:text-lg">Watch powerful lessons and visual motivation.</p>
                </div>
                <a href="{{ route('videos') }}" class="mt-4 sm:mt-0 px-6 py-3 rounded-full bg-[#EEEBD9]/10 text-white font-bold hover:bg-[#BC6C25] transition-colors border border-white/10">Browse Library</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8 relative z-10">
                @foreach($videos as $vid)
                @if($vid->post)
                <a href="{{ route('posts.show', $vid->post->slug) }}#videos" wire:navigate class="group block text-left">
                    <div class="relative aspect-[16/9] bg-black rounded-2xl overflow-hidden mb-4 shadow-xl ring-1 ring-white/10">
                        @if($vid->post->feature_image)
                            <img src="{{ $vid->post->feature_image }}" class="w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-700" alt="" loading="lazy">
                        @endif
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#BC6C25] text-white flex items-center justify-center shadow-[0_0_30px_rgba(188,108,37,0.6)] group-hover:scale-110 transition-transform">
                                <flux:icon.play class="w-6 h-6 sm:w-7 sm:h-7 ml-1" />
                            </div>
                        </div>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-white group-hover:text-[#BC6C25] transition-colors leading-snug line-clamp-2">{{ $vid->title ?? $vid->post->title }}</h3>
                </a>
                @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- 6. LATEST ARTICLES FEED --}}
    @if($latestPosts && $latestPosts->count() > 0)
    <section class="max-w-4xl mx-auto px-4 sm:px-6">
        <h2 class="text-2xl sm:text-3xl font-black text-[#282427] mb-8 sm:mb-10 text-center">Inspiration Feed</h2>
        <div class="flex flex-col gap-6 sm:gap-8">
            @foreach($latestPosts as $post)
            <article x-data="{ showComments: false }" class="bg-white rounded-2xl border border-[#282427]/5 shadow-[0_4px_20px_rgba(40,36,39,0.04)] overflow-hidden">
                <div class="p-4 sm:p-5 md:p-6 pb-2 sm:pb-3">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full ring-2 ring-[#BC6C25]/20 bg-[#282427] text-white flex items-center justify-center font-bold text-sm sm:text-lg shadow-sm">
                            {{ substr($post->user->name, 0, 2) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-[#282427] text-sm sm:text-base leading-tight">{{ $post->user->name }}</h3>
                            <p class="text-xs sm:text-[13px] font-medium text-[#282427]/50 mt-0.5">
                                {{ $post->created_at->diffForHumans() }}
                                @if($post->category)
                                    &middot; <a href="{{ route('categories.show', $post->category->slug) }}" class="text-[#BC6C25] hover:underline">{{ $post->category->name }}</a>
                                @endif
                                &middot; {{ $post->reading_time }} min read
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <a href="{{ route('posts.show', $post->slug) }}" class="block mb-2 group">
                            <h2 class="text-lg sm:text-xl md:text-[22px] font-black text-[#282427] group-hover:text-[#BC6C25] transition-colors leading-[1.3]">{{ $post->title }}</h2>
                        </a>
                        <p class="text-[#282427]/80 text-sm sm:text-[15px] leading-relaxed mb-4">
                            {{ Str::limit(strip_tags($post->content), 250) }}
                        </p>

                        @if($post->feature_image)
                        <a href="{{ route('posts.show', $post->slug) }}" class="block relative w-full aspect-video rounded-xl overflow-hidden bg-[#282427]/5">
                            <img src="{{ $post->feature_image }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" alt="" loading="lazy">
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Real Action Bar --}}
                <div class="px-3 sm:px-4 py-2.5 border-t border-[#282427]/5 flex items-center justify-between bg-[#FDFCFA]">
                    <div class="flex items-center gap-1">
                        <livewire:like-button :likeable="$post" :wire:key="'like-home-'.$post->id" />

                        <button @click="showComments = !showComments"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-bold transition-colors"
                            :class="showComments ? 'text-[#BC6C25] bg-[#BC6C25]/10' : 'text-zinc-500 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5'">
                            <flux:icon.chat-bubble-left class="w-5 h-5" />
                            <span class="hidden sm:inline">{{ $post->comments_count }}</span>
                        </button>

                        <button
                            x-data
                            @click="navigator.clipboard.writeText('{{ url('/posts/' . $post->slug) }}'); $el.querySelector('span').textContent = 'Copied!'; setTimeout(() => $el.querySelector('span').textContent = 'Share', 2000)"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-zinc-500 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5 transition-colors text-sm font-bold">
                            <flux:icon.share class="w-5 h-5" />
                            <span class="hidden sm:inline">Share</span>
                        </button>

                        <livewire:bookmark-button :post="$post" :wire:key="'bookmark-home-'.$post->id" />
                    </div>
                </div>

                {{-- Inline Comments --}}
                <div x-show="showComments" x-transition style="display: none;" class="border-t border-[#282427]/5 bg-[#F9F8F5] p-2 sm:p-3 md:p-4">
                    <livewire:comment-section :post="$post" :wire:key="'comments-feed-'.$post->id" />
                </div>
            </article>
            @endforeach
        </div>
        <div class="mt-12 sm:mt-16 flex justify-center">
            {{ $latestPosts->links() }}
        </div>
    </section>
    @endif

    {{-- 7. NEWSLETTER --}}
    <section class="max-w-4xl mx-auto px-4 sm:px-6 pt-6 sm:pt-10">
        <div class="bg-gradient-to-br from-[#BC6C25] to-[#A65D1F] rounded-3xl sm:rounded-[32px] p-8 sm:p-10 md:p-16 text-center shadow-xl shadow-[#BC6C25]/20 relative overflow-hidden">
            <div class="relative z-10">
                <flux:icon.envelope-open class="w-10 h-10 sm:w-12 sm:h-12 text-white/50 mx-auto mb-4 sm:mb-6" />
                <h2 class="text-2xl sm:text-3xl md:text-5xl font-black text-white mb-4 sm:mb-6 leading-tight">Join the Inner Circle</h2>
                <p class="text-white/90 text-base sm:text-lg mb-8 sm:mb-10 max-w-lg mx-auto">Get exclusive growth tips, motivational drops, and unreleased content straight to your inbox.</p>
                <livewire:newsletter-subscribe />
            </div>
            <svg class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,100 C20,0 50,0 100,100" fill="currentColor"/></svg>
        </div>
    </section>

</div>
