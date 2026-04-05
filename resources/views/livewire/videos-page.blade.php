<div class="space-y-8 pb-16">
    <div class="text-center py-8 px-4">
        <h1 class="text-4xl md:text-5xl font-black text-[#282427] mb-3">Video Library</h1>
        <p class="text-lg text-[#282427]/60 max-w-lg mx-auto">Watch lessons and motivation, then dive deeper in the full article.</p>
    </div>

    @if($categories->count() > 0)
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex flex-wrap gap-2 justify-center">
            <button type="button" wire:click="$set('category', '')"
                class="px-4 py-2 rounded-full text-sm font-bold transition-all {{ $category === '' ? 'bg-[#BC6C25] text-white shadow-lg shadow-[#BC6C25]/25' : 'bg-white text-[#282427]/70 border border-[#282427]/10' }}">
                All
            </button>
            @foreach($categories as $cat)
                <button type="button" wire:click="$set('category', '{{ $cat->slug }}')"
                    class="px-4 py-2 rounded-full text-sm font-bold transition-all {{ $category === $cat->slug ? 'bg-[#282427] text-white' : 'bg-white text-[#282427]/70 border border-[#282427]/10 hover:border-[#BC6C25]/30' }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
    </div>
    @endif

    <div class="max-w-7xl mx-auto px-6">
        @if($videos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($videos as $video)
                    @if($video->post)
                        <article class="group bg-white rounded-2xl border border-[#282427]/5 shadow-sm overflow-hidden hover:shadow-xl transition-all">
                            <a href="{{ route('posts.show', $video->post->slug) }}#videos" wire:navigate class="block relative aspect-[16/9] bg-[#282427] overflow-hidden">
                                @if($video->post->feature_image)
                                    <img src="{{ $video->post->feature_image }}" class="w-full h-full object-cover opacity-75 group-hover:scale-105 transition-transform duration-500" alt="" loading="lazy">
                                @endif
                                @php
                                    $youtubeId = '';
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $video->youtube_url, $match)) {
                                        $youtubeId = $match[1];
                                    }
                                @endphp
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-[#BC6C25] text-white flex items-center justify-center shadow-[0_0_30px_rgba(188,108,37,0.5)] group-hover:scale-110 transition-transform">
                                        <flux:icon.play class="w-7 h-7 ml-1" />
                                    </div>
                                </div>
                                @if($video->duration)
                                    <span class="absolute bottom-3 right-3 px-2 py-1 bg-black/70 text-white text-xs font-bold rounded-md">{{ $video->duration }}</span>
                                @endif
                            </a>
                            <div class="p-5">
                                <h3 class="text-lg font-bold text-[#282427] group-hover:text-[#BC6C25] transition-colors line-clamp-2 mb-2">
                                    <a href="{{ route('posts.show', $video->post->slug) }}#videos" wire:navigate>{{ $video->title ?? $video->post->title }}</a>
                                </h3>
                                <p class="text-sm text-[#282427]/50 mb-4">{{ $video->post->user->name }} · {{ $video->post->created_at->diffForHumans() }}</p>
                                <div class="flex items-center justify-between gap-3 flex-wrap">
                                    <a href="{{ route('posts.show', $video->post->slug) }}" wire:navigate class="text-xs font-bold text-[#BC6C25] hover:underline">Read full story</a>
                                    @auth
                                        <livewire:bookmark-button :post="$video->post" :wire:key="'bookmark-video-'.$video->id" />
                                    @endauth
                                </div>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
            <div class="mt-12 flex justify-center">
                {{ $videos->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border border-[#282427]/5">
                <flux:icon.play-circle class="w-16 h-16 text-[#282427]/15 mb-4" />
                <h3 class="text-xl font-bold text-[#282427] mb-2">No videos in this filter</h3>
                <p class="text-[#282427]/50 mb-6">Try another category or explore all posts.</p>
                <button type="button" wire:click="$set('category', '')" class="px-6 py-3 bg-[#BC6C25] text-white rounded-full font-bold shadow-lg">Show all videos</button>
            </div>
        @endif
    </div>
</div>
