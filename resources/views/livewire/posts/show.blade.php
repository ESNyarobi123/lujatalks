<div class="pb-28 lg:pb-16"
    x-data="{
        pct: 0,
        scroll() {
            const start = document.getElementById('reading-start');
            const end = document.getElementById('reading-end');
            if (! start || ! end) {
                this.pct = 0;
                return;
            }
            const range = end.offsetTop - start.offsetTop;
            if (range <= 0) {
                this.pct = 0;
                return;
            }
            const scrolled = window.scrollY + window.innerHeight * 0.25 - start.offsetTop;
            this.pct = Math.max(0, Math.min(100, Math.round((scrolled / range) * 100)));
        },
    }"
    x-init="scroll(); window.addEventListener('scroll', () => scroll(), { passive: true })">
    <div class="fixed top-16 sm:top-20 left-0 right-0 h-1 z-40 bg-[#282427]/10 pointer-events-none" aria-hidden="true">
        <div class="h-full bg-[#BC6C25] transition-[width] duration-150 ease-out shadow-[0_0_12px_rgba(188,108,37,0.45)]" :style="'width:' + pct + '%'"></div>
    </div>

    {{-- Post Header --}}
    <article class="max-w-4xl mx-auto">
        {{-- Feature Image --}}
        @if($post->feature_image)
            <div class="w-full aspect-[2/1] rounded-3xl overflow-hidden mb-8 shadow-lg">
                <img src="{{ $post->feature_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        {{-- Meta --}}
        <div class="flex flex-wrap items-center gap-3 mb-6">
            @if($post->category)
                <a href="{{ route('categories.show', $post->category->slug) }}"
                    class="px-4 py-1.5 bg-[#BC6C25]/10 text-[#BC6C25] text-xs font-bold uppercase tracking-widest rounded-full hover:bg-[#BC6C25]/20 transition-colors">
                    {{ $post->category->name }}
                </a>
            @endif
            <span class="text-sm text-[#282427]/40 font-medium">{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
            <span class="text-sm text-[#282427]/40 font-medium flex items-center gap-1">
                <flux:icon.clock class="w-4 h-4" /> {{ $post->reading_time }} min read
            </span>
            <span class="text-sm text-[#282427]/40 font-medium flex items-center gap-1">
                <flux:icon.eye class="w-4 h-4" /> {{ number_format($post->views_count) }} views
            </span>
        </div>

        {{-- Title --}}
        <h1 id="reading-start" class="text-3xl sm:text-4xl md:text-5xl font-black text-[#282427] leading-tight mb-6 scroll-mt-28">
            {{ $post->title }}
        </h1>

        {{-- Author + Actions --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-10 pb-8 border-b border-[#282427]/10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#282427] text-white flex items-center justify-center font-bold text-lg">
                    {{ substr($post->user->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="font-bold text-[#282427]">
                        @if($post->user->profile_slug)
                            <a href="{{ route('authors.show', $post->user->profile_slug) }}" wire:navigate class="hover:text-[#BC6C25] transition-colors">{{ $post->user->name }}</a>
                        @else
                            {{ $post->user->name }}
                        @endif
                    </h3>
                    <p class="text-sm text-[#282427]/50">Author at Luja Talks</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <livewire:like-button :likeable="$post" :wire:key="'like-show-'.$post->id" />

                <livewire:bookmark-button :post="$post" :wire:key="'bookmark-show-'.$post->id" />

                <button
                    x-data
                    @click="navigator.clipboard.writeText(window.location.href); $el.querySelector('span').textContent = 'Copied!'; setTimeout(() => $el.querySelector('span').textContent = 'Share', 2000)"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl font-bold text-sm bg-white text-[#282427]/60 border border-[#282427]/10 hover:border-[#BC6C25]/20 hover:text-[#BC6C25] transition-all">
                    <flux:icon.share class="w-5 h-5" />
                    <span>Share</span>
                </button>
            </div>
        </div>

        {{-- Tags --}}
        @if($post->tags->count() > 0)
            <div class="flex flex-wrap gap-2 mb-8">
                @foreach($post->tags as $tag)
                    <a href="{{ route('explore', ['tag' => $tag->slug]) }}"
                        class="px-3 py-1.5 bg-white rounded-full border border-[#282427]/10 text-xs font-bold text-[#282427]/60 hover:text-[#BC6C25] hover:border-[#BC6C25]/30 transition-colors">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Post Content --}}
        <div class="prose prose-lg max-w-none
            prose-headings:text-[#282427] prose-headings:font-black
            prose-p:text-[#282427]/80 prose-p:leading-relaxed
            prose-a:text-[#BC6C25] prose-a:font-bold prose-a:no-underline hover:prose-a:underline
            prose-strong:text-[#282427]
            prose-img:rounded-2xl prose-img:shadow-md
            prose-blockquote:border-[#BC6C25] prose-blockquote:bg-[#BC6C25]/5 prose-blockquote:rounded-r-xl prose-blockquote:py-2
            ">
            {!! $post->sanitized_content !!}
        </div>
        <div id="reading-end" class="sr-only" aria-hidden="true"></div>

        {{-- Videos --}}
        @if($post->videos->count() > 0)
            <div id="videos" class="mt-12 mb-8 scroll-mt-28">
                <h3 class="text-xl font-black text-[#282427] mb-4 flex items-center gap-2">
                    <flux:icon.play-circle class="w-6 h-6 text-[#BC6C25]" /> Related Videos
                </h3>
                @foreach($post->videos as $video)
                    <div class="aspect-video w-full rounded-2xl overflow-hidden shadow-lg border border-[#282427]/5 mb-4">
                        @php
                            $youtubeId = '';
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $video->youtube_url, $match)) {
                                $youtubeId = $match[1];
                            }
                        @endphp
                        @if($youtubeId)
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                        @else
                            <a href="{{ $video->youtube_url }}" target="_blank" class="w-full h-full bg-[#282427]/5 flex items-center justify-center flex-col hover:bg-[#282427]/10 transition-colors">
                                <flux:icon.play-circle class="w-12 h-12 text-[#BC6C25] mb-2" />
                                <span class="text-[#282427]/60 font-bold">Watch {{ $video->title ?? 'Video' }}</span>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Author Card --}}
        <div class="mt-12 flex items-center gap-4 bg-white p-6 rounded-2xl border border-[#282427]/5 shadow-sm">
            @if($post->user->profile_slug)
                <a href="{{ route('authors.show', $post->user->profile_slug) }}" wire:navigate class="w-14 h-14 rounded-full bg-[#282427] text-white flex items-center justify-center font-bold text-xl flex-shrink-0 hover:ring-2 hover:ring-[#BC6C25]/40 transition-all">
                    {{ substr($post->user->name, 0, 1) }}
                </a>
            @else
                <div class="w-14 h-14 rounded-full bg-[#282427] text-white flex items-center justify-center font-bold text-xl flex-shrink-0">
                    {{ substr($post->user->name, 0, 1) }}
                </div>
            @endif
            <div>
                <h3 class="text-lg font-bold text-[#282427]">
                    @if($post->user->profile_slug)
                        <a href="{{ route('authors.show', $post->user->profile_slug) }}" wire:navigate class="hover:text-[#BC6C25] transition-colors">{{ $post->user->name }}</a>
                    @else
                        {{ $post->user->name }}
                    @endif
                </h3>
                <p class="text-sm text-[#282427]/50 mt-1">Author at Luja Talks · {{ $post->user->posts()->where('status', 'published')->count() }} articles</p>
            </div>
        </div>
    </article>

    {{-- Comments Section --}}
    <div class="max-w-4xl mx-auto mt-10">
        <livewire:comment-section :post="$post" />
    </div>

    {{-- Related Posts --}}
    @if($relatedPosts->count() > 0)
        <div class="max-w-4xl mx-auto mt-12">
            <h2 class="text-2xl font-black text-[#282427] mb-2">Related inspiration</h2>
            <p class="text-[#282427]/50 text-sm mb-6">Keep the momentum going with more from this topic.</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($relatedPosts as $related)
                    <a href="{{ route('posts.show', $related->slug) }}" class="group bg-white rounded-2xl border border-[#282427]/5 shadow-sm overflow-hidden hover:-translate-y-1 transition-all">
                        @if($related->feature_image)
                            <div class="h-36 overflow-hidden">
                                <img src="{{ $related->feature_image }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            </div>
                        @endif
                        <div class="p-4">
                            @if($related->category)
                                <span class="text-xs font-bold text-[#BC6C25] uppercase tracking-widest">{{ $related->category->name }}</span>
                            @endif
                            <h3 class="font-bold text-[#282427] group-hover:text-[#BC6C25] transition-colors text-sm line-clamp-2 mt-1">{{ $related->title }}</h3>
                            <p class="text-xs text-[#282427]/40 mt-2">{{ $related->reading_time }} min read</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Mobile sticky engagement bar --}}
    <div class="lg:hidden fixed bottom-0 inset-x-0 z-40 border-t border-[#282427]/10 bg-[#EEEBD9]/95 backdrop-blur-md px-2 py-2 pb-3">
        <div class="max-w-lg mx-auto flex items-center justify-around gap-1">
            <livewire:like-button :likeable="$post" :wire:key="'like-sticky-'.$post->id" />
            <livewire:bookmark-button :post="$post" :wire:key="'bookmark-sticky-'.$post->id" />
            <a href="#comments" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-xl text-[#282427]/60 hover:text-[#BC6C25] min-w-[4rem]">
                <flux:icon.chat-bubble-left class="w-6 h-6" />
                <span class="text-[10px] font-bold">Discuss</span>
            </a>
            <button type="button"
                x-data
                @click="navigator.clipboard.writeText(window.location.href)"
                class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-xl text-[#282427]/60 hover:text-[#BC6C25] min-w-[4rem]">
                <flux:icon.share class="w-6 h-6" />
                <span class="text-[10px] font-bold">Share</span>
            </button>
        </div>
    </div>
</div>
