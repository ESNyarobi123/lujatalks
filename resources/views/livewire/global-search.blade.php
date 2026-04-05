<div class="space-y-8 pb-16">
    <div class="text-center py-8">
        <h1 class="text-4xl md:text-5xl font-black text-[#282427] mb-3">Search</h1>
    </div>

    {{-- Search Input --}}
    <div class="max-w-2xl mx-auto px-6">
        <div class="relative">
            <flux:icon.magnifying-glass class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-[#282427]/30" />
            <input wire:model.live.debounce.300ms="q" type="text" placeholder="Search articles, categories, tags..."
                class="w-full pl-14 pr-6 py-4 rounded-2xl bg-white border border-[#282427]/10 text-[#282427] text-lg placeholder-[#282427]/30 focus:ring-2 focus:ring-[#BC6C25]/30 focus:border-[#BC6C25] transition-all font-medium shadow-lg shadow-[#282427]/5"
                autofocus />
        </div>
    </div>

    @if(strlen($q) >= 2)
        <div class="max-w-4xl mx-auto px-6 space-y-8">
            {{-- Categories --}}
            @if($categories->count() > 0)
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-widest text-[#282427]/40 mb-4">Categories</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($categories as $cat)
                            <a href="{{ route('categories.show', $cat->slug) }}" class="px-5 py-3 bg-white rounded-xl border border-[#282427]/10 hover:border-[#BC6C25]/30 transition-colors flex items-center gap-2 group shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-[#BC6C25]"></span>
                                <span class="font-bold text-[#282427] group-hover:text-[#BC6C25] transition-colors">{{ $cat->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Tags --}}
            @if($tags->count() > 0)
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-widest text-[#282427]/40 mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('explore', ['tag' => $tag->slug]) }}" class="px-4 py-2 bg-white rounded-full border border-[#282427]/10 hover:border-[#BC6C25]/30 text-sm font-medium text-[#282427]/70 hover:text-[#BC6C25] transition-colors">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Videos --}}
            @if($videos->count() > 0)
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-widest text-[#282427]/40 mb-4">Videos</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($videos as $video)
                            @if($video->post)
                                <a href="{{ route('posts.show', $video->post->slug) }}#videos" class="group flex gap-4 p-4 bg-white rounded-xl border border-[#282427]/5 hover:shadow-md transition-all">
                                    <div class="w-28 h-20 rounded-lg overflow-hidden bg-[#282427] flex-shrink-0 relative">
                                        @if($video->post->feature_image)
                                            <img src="{{ $video->post->feature_image }}" class="w-full h-full object-cover opacity-80" alt="" loading="lazy">
                                        @endif
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <flux:icon.play class="w-8 h-8 text-white drop-shadow-lg" />
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-black text-[#282427] group-hover:text-[#BC6C25] transition-colors line-clamp-2 text-sm">{{ $video->title ?? $video->post->title }}</h4>
                                        <p class="text-xs text-[#282427]/40 mt-1">Watch with article</p>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Posts --}}
            @if($posts->count() > 0)
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-widest text-[#282427]/40 mb-4">Articles ({{ $posts->count() }})</h3>
                    <div class="flex flex-col gap-4">
                        @foreach($posts as $post)
                            <a href="{{ route('posts.show', $post->slug) }}" class="group flex gap-4 p-4 bg-white rounded-xl border border-[#282427]/5 hover:shadow-md transition-all">
                                @if($post->feature_image)
                                    <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                                        <img src="{{ $post->feature_image }}" class="w-full h-full object-cover" alt="">
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    @if($post->category)
                                        <span class="text-xs font-bold uppercase tracking-widest text-[#BC6C25]">{{ $post->category->name }}</span>
                                    @endif
                                    <h4 class="text-lg font-black text-[#282427] group-hover:text-[#BC6C25] transition-colors line-clamp-1 mt-1">{{ $post->title }}</h4>
                                    <p class="text-sm text-[#282427]/50 line-clamp-1 mt-1">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                    <div class="flex items-center gap-3 mt-2 text-xs text-[#282427]/40">
                                        <span>{{ $post->user->name }}</span>
                                        <span>·</span>
                                        <span>{{ $post->reading_time }} min read</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($posts->count() === 0 && $categories->count() === 0 && $tags->count() === 0 && $videos->count() === 0)
                <div class="text-center py-16">
                    <flux:icon.magnifying-glass class="w-16 h-16 text-[#282427]/10 mx-auto mb-4" />
                    <h3 class="text-xl font-bold text-[#282427] mb-2">No results for "{{ $q }}"</h3>
                    <p class="text-[#282427]/50">Try different keywords or browse categories.</p>
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-16 max-w-lg mx-auto">
            <flux:icon.sparkles class="w-12 h-12 text-[#BC6C25]/30 mx-auto mb-4" />
            <p class="text-[#282427]/50">Start typing to search across articles, categories, and tags.</p>
        </div>
    @endif
</div>
