<div class="space-y-8 pb-16">
    <div class="py-8">
        <div class="flex items-center gap-3 mb-2">
            <span class="w-3 h-3 rounded-full bg-[#BC6C25]"></span>
            <h1 class="text-3xl md:text-4xl font-black text-[#282427]">{{ $category->name }}</h1>
        </div>
        @if($category->description)
            <p class="text-lg text-[#282427]/60 max-w-xl">{{ $category->description }}</p>
        @endif
        <p class="text-sm text-[#282427]/40 mt-2 font-medium">{{ $posts->total() }} {{ Str::plural('article', $posts->total()) }}</p>
    </div>

    <div class="max-w-7xl mx-auto">
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
                            <span class="text-xs text-[#282427]/40 font-medium">{{ $post->reading_time }} min read</span>
                            <a href="{{ route('posts.show', $post->slug) }}" class="block mt-2 mb-3">
                                <h3 class="text-lg font-black text-[#282427] group-hover:text-[#BC6C25] transition-colors leading-snug line-clamp-2">{{ $post->title }}</h3>
                            </a>
                            <p class="text-sm text-[#282427]/60 line-clamp-2 mb-4">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                            <div class="flex items-center justify-between pt-3 border-t border-[#282427]/5">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-[#282427] text-white flex items-center justify-center font-bold text-xs">{{ substr($post->user->name, 0, 1) }}</div>
                                    <span class="text-xs font-medium text-[#282427]/60">{{ $post->user->name }}</span>
                                </div>
                                <span class="text-xs text-[#282427]/40">{{ $post->published_at?->diffForHumans() ?? $post->created_at->diffForHumans() }}</span>
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
                <flux:icon.document-text class="w-16 h-16 text-[#282427]/15 mb-4" />
                <h3 class="text-xl font-bold text-[#282427] mb-2">No articles in this category</h3>
                <p class="text-[#282427]/50">Content is coming soon. Check back later!</p>
            </div>
        @endif
    </div>
</div>
