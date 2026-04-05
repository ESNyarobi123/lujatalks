<div class="max-w-4xl mx-auto space-y-10 pb-20 px-4 sm:px-0">
    <div class="bg-white rounded-3xl border border-[#282427]/5 shadow-sm p-8 sm:p-10">
        <div class="flex flex-col sm:flex-row gap-6 items-start">
            <div class="w-20 h-20 rounded-2xl bg-[#282427] text-white flex items-center justify-center font-black text-3xl shrink-0 shadow-lg">
                {{ $author->initials() }}
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="text-3xl sm:text-4xl font-black text-[#282427] tracking-tight">{{ $author->name }}</h1>
                <p class="text-sm font-bold text-[#BC6C25] mt-1">Contributor at Luja Talks</p>
                @if($author->bio)
                    <p class="text-[#282427]/70 mt-4 leading-relaxed whitespace-pre-wrap">{{ $author->bio }}</p>
                @else
                    <p class="text-[#282427]/50 mt-4 italic">Building the future, one story at a time.</p>
                @endif
                <p class="text-xs text-[#282427]/40 mt-4">{{ $posts->total() }} published {{ Str::plural('article', $posts->total()) }}</p>
            </div>
        </div>
    </div>

    <div>
        <h2 class="text-xl font-black text-[#282427] mb-6 flex items-center gap-2">
            <flux:icon.newspaper class="w-6 h-6 text-[#BC6C25]" /> Articles
        </h2>
        @if($posts->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-[#282427]/10">
                <p class="text-[#282427]/50">No published articles yet.</p>
                <a href="{{ route('explore') }}" wire:navigate class="inline-block mt-4 text-[#BC6C25] font-bold hover:underline">Explore the library</a>
            </div>
        @else
            <div class="flex flex-col gap-4">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post->slug) }}" wire:navigate class="group flex gap-4 p-5 bg-white rounded-2xl border border-[#282427]/5 hover:shadow-md hover:border-[#BC6C25]/20 transition-all">
                        @if($post->feature_image)
                            <div class="w-28 h-20 rounded-xl overflow-hidden shrink-0 hidden sm:block">
                                <img src="{{ $post->feature_image }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform" loading="lazy">
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            @if($post->category)
                                <span class="text-xs font-bold text-[#BC6C25] uppercase tracking-widest">{{ $post->category->name }}</span>
                            @endif
                            <h3 class="text-lg font-black text-[#282427] group-hover:text-[#BC6C25] transition-colors line-clamp-2 mt-1">{{ $post->title }}</h3>
                            <p class="text-xs text-[#282427]/40 mt-2">{{ $post->reading_time }} min read · {{ $post->published_at?->format('M j, Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-8 flex justify-center">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
