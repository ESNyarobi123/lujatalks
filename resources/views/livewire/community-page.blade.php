<div class="max-w-3xl mx-auto space-y-8 pb-20 px-4 sm:px-0">
    <div class="text-center pt-6 sm:pt-10">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#BC6C25]/10 text-[#BC6C25] font-bold text-sm mb-4">
            <flux:icon.chat-bubble-left-right class="w-4 h-4" /> Live discussions
        </div>
        <h1 class="text-4xl sm:text-5xl font-black text-[#282427] mb-3">Community</h1>
        <p class="text-lg text-[#282427]/60 max-w-lg mx-auto">Real voices on the posts that move us. Jump in and add yours.</p>
    </div>

    @if($comments->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-dashed border-[#282427]/10">
            <flux:icon.sparkles class="w-14 h-14 text-[#BC6C25]/30 mb-4" />
            <h3 class="text-xl font-bold text-[#282427] mb-2">The conversation is warming up</h3>
            <p class="text-[#282427]/50 text-center max-w-sm mb-6">Be the first to comment on a story — your perspective matters here.</p>
            <a href="{{ route('explore') }}" wire:navigate class="px-6 py-3 bg-[#BC6C25] text-white rounded-full font-bold shadow-lg">Find a post to join</a>
        </div>
    @else
        <div class="flex flex-col gap-4">
            @foreach($comments as $comment)
                <article id="comment-{{ $comment->id }}" class="bg-white rounded-2xl border border-[#282427]/5 p-5 sm:p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-[#282427] text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                            {{ $comment->user->initials() }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-bold text-[#282427] text-sm">{{ $comment->user->name }}</p>
                            <p class="text-xs text-[#282427]/40">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <p class="text-[#282427]/80 text-sm leading-relaxed whitespace-pre-wrap mb-4">{{ Str::limit($comment->content, 280) }}</p>
                    @if($comment->post)
                        <a href="{{ route('posts.show', $comment->post->slug) }}#comments" wire:navigate
                            class="inline-flex items-center gap-2 text-sm font-bold text-[#BC6C25] hover:underline">
                            <span>On: {{ Str::limit($comment->post->title, 56) }}</span>
                            @if($comment->post->category)
                                <span class="text-[#282427]/40 font-medium">· {{ $comment->post->category->name }}</span>
                            @endif
                            <flux:icon.arrow-right class="w-4 h-4" />
                        </a>
                    @endif
                </article>
            @endforeach
        </div>
        <div class="mt-8 flex justify-center">
            {{ $comments->links() }}
        </div>
    @endif
</div>
