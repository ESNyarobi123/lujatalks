<div class="space-y-8 pb-16">

    {{-- Page Header --}}
    <div class="text-center py-8">
        <h1 class="text-4xl md:text-5xl font-black text-[#282427] mb-3">Explore</h1>
        <p class="text-lg text-[#282427]/60 max-w-lg mx-auto">Discover articles, stories and ideas that fuel your growth journey.</p>
    </div>

    @if($featuredStrip->count() > 0)
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold uppercase tracking-widest text-[#282427]/40">Featured &amp; trending</h2>
            <span class="text-xs font-bold text-[#BC6C25]">Updated daily</span>
        </div>
        <div class="flex gap-4 overflow-x-auto pb-2 snap-x snap-mandatory scrollbar-thin">
            @foreach($featuredStrip as $fp)
                <a href="{{ route('posts.show', $fp->slug) }}" wire:navigate
                    class="snap-start flex-shrink-0 w-[280px] sm:w-[300px] bg-white rounded-2xl border border-[#282427]/5 shadow-sm overflow-hidden hover:shadow-lg hover:border-[#BC6C25]/20 transition-all group">
                    @if($fp->feature_image)
                        <div class="h-32 overflow-hidden">
                            <img src="{{ $fp->feature_image }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        </div>
                    @endif
                    <div class="p-4">
                        @if($fp->is_trending)
                            <span class="text-[10px] font-black uppercase tracking-wider text-[#BC6C25]">Trending</span>
                        @endif
                        <h3 class="font-black text-[#282427] text-sm line-clamp-2 mt-1 group-hover:text-[#BC6C25]">{{ $fp->title }}</h3>
                        <p class="text-xs text-[#282427]/40 mt-2">{{ $fp->reading_time }} min · {{ $fp->likes_count }} likes</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Search + Filters --}}
    <div class="max-w-4xl mx-auto px-6">
        <div class="flex flex-col md:flex-row gap-4 items-stretch">
            <div class="flex-1 relative">
                <flux:icon.magnifying-glass class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-[#282427]/40" />
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search articles..."
                    class="w-full pl-12 pr-4 py-3.5 rounded-xl bg-white border border-[#282427]/10 text-[#282427] placeholder-[#282427]/40 focus:ring-2 focus:ring-[#BC6C25]/30 focus:border-[#BC6C25] transition-all font-medium shadow-sm" />
            </div>
            <select wire:model.live="sort"
                class="px-4 py-3.5 rounded-xl bg-white border border-[#282427]/10 text-[#282427] font-bold text-sm shadow-sm focus:ring-2 focus:ring-[#BC6C25]/30">
                <option value="latest">Latest</option>
                <option value="popular">Most Popular</option>
                <option value="trending">Trending</option>
            </select>
        </div>
    </div>

    {{-- Category Pills --}}
    @if($categories->count() > 0)
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex flex-wrap gap-2">
            <button wire:click="$set('category', '')"
                class="px-4 py-2 rounded-full text-sm font-bold transition-all {{ $category === '' ? 'bg-[#BC6C25] text-white shadow-lg shadow-[#BC6C25]/25' : 'bg-white text-[#282427]/70 border border-[#282427]/10 hover:border-[#BC6C25]/30' }}">
                All
            </button>
            @foreach($categories as $cat)
                <button wire:click="$set('category', '{{ $cat->slug }}')"
                    class="px-4 py-2 rounded-full text-sm font-bold transition-all {{ $category === $cat->slug ? 'bg-[#BC6C25] text-white shadow-lg shadow-[#BC6C25]/25' : 'bg-white text-[#282427]/70 border border-[#282427]/10 hover:border-[#BC6C25]/30' }}">
                    {{ $cat->name }} <span class="text-xs opacity-70">({{ $cat->posts_count }})</span>
                </button>
            @endforeach
        </div>
    </div>
    @endif

    @if($tags->count() > 0)
    <div class="max-w-5xl mx-auto px-6">
        <h3 class="text-xs font-bold uppercase tracking-widest text-[#282427]/40 mb-3">Tags</h3>
        <div class="flex flex-wrap gap-2">
            <button type="button" wire:click="$set('tag', '')"
                class="px-3 py-1.5 rounded-full text-xs font-bold transition-all {{ $tag === '' ? 'bg-[#282427] text-white' : 'bg-white text-[#282427]/60 border border-[#282427]/10 hover:border-[#BC6C25]/30' }}">
                All tags
            </button>
            @foreach($tags as $t)
                <button type="button" wire:click="$set('tag', '{{ $t->slug }}')"
                    class="px-3 py-1.5 rounded-full text-xs font-bold transition-all {{ $tag === $t->slug ? 'bg-[#BC6C25] text-white' : 'bg-white text-[#282427]/60 border border-[#282427]/10 hover:border-[#BC6C25]/30' }}">
                    #{{ $t->name }}
                </button>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Posts Grid --}}
    <div class="max-w-7xl mx-auto px-6">
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <article class="group bg-white rounded-2xl border border-[#282427]/5 shadow-[0_4px_20px_rgba(0,0,0,0.03)] overflow-hidden hover:-translate-y-1 transition-all duration-300">
                        @if($post->feature_image)
                            <a href="{{ route('posts.show', $post->slug) }}" class="block h-48 overflow-hidden">
                                <img src="{{ $post->feature_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </a>
                        @endif
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-3">
                                @if($post->category)
                                    <span class="text-xs font-bold uppercase tracking-widest text-[#BC6C25]">{{ $post->category->name }}</span>
                                @endif
                                <span class="text-xs text-[#282427]/40">· {{ $post->reading_time }} min read</span>
                            </div>
                            <a href="{{ route('posts.show', $post->slug) }}" class="block mb-3">
                                <h3 class="text-lg font-black text-[#282427] group-hover:text-[#BC6C25] transition-colors leading-snug line-clamp-2">{{ $post->title }}</h3>
                            </a>
                            <p class="text-sm text-[#282427]/60 line-clamp-2 mb-4">{{ Str::limit(strip_tags($post->content), 120) }}</p>

                            <div class="flex items-center justify-between pt-3 border-t border-[#282427]/5">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-[#282427] text-white flex items-center justify-center font-bold text-xs">{{ substr($post->user->name, 0, 1) }}</div>
                                    <span class="text-xs font-medium text-[#282427]/60">{{ $post->user->name }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-[#282427]/40">
                                    <span class="flex items-center gap-1">
                                        <flux:icon.heart class="w-3.5 h-3.5" /> {{ $post->likes_count }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <flux:icon.chat-bubble-left class="w-3.5 h-3.5" /> {{ $post->comments_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-12 flex justify-center">
                {{ $posts->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border border-[#282427]/5">
                <flux:icon.magnifying-glass class="w-16 h-16 text-[#282427]/15 mb-4" />
                <h3 class="text-xl font-bold text-[#282427] mb-2">No articles found</h3>
                <p class="text-[#282427]/50 text-center max-w-sm">
                    @if($search)
                        No results for "{{ $search }}". Try different keywords.
                    @elseif($tag !== '')
                        No articles with this tag right now. Try another tag.
                    @elseif($category !== '')
                        No articles in this category yet. Check back soon!
                    @else
                        No articles match your filters yet. Check back soon!
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
