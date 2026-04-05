<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Post Comments</h1>
            <p class="text-zinc-500 mt-1">Moderate user discussions and community feedback.</p>
        </div>
    </div>

    @if(session('status'))
        <flux:toast variant="success" text="{{ session('status') }}" heading="Success" />
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden px-6 py-5">
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="flex-1 max-w-sm">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search comments or users..." icon="magnifying-glass" />
            </div>
        </div>

        <div class="overflow-x-auto -mx-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-y border-zinc-200/60 bg-zinc-50/50">
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500 w-1/4">User</th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500 w-1/2">Comment Content</th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500 w-1/4">Target Post</th>
                        <th class="py-3 px-6 text-right text-xs font-bold uppercase tracking-wider text-zinc-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60">
                    @forelse($comments as $comment)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="py-4 px-6 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-zinc-800 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-1">
                                    {{ substr($comment->user->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-zinc-900">{{ $comment->user->name }}</p>
                                    <p class="text-[10px] text-zinc-500">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="bg-zinc-50 p-3 rounded-lg border border-zinc-100 text-sm text-zinc-700 break-words line-clamp-3">
                                    {{ $comment->content }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('posts.show', $comment->post->slug) }}" target="_blank" class="text-sm font-semibold text-[#BC6C25] hover:underline line-clamp-2">
                                    {{ $comment->post->title }}
                                </a>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <flux:button size="sm" variant="ghost" icon="trash" wire:click="delete({{ $comment->id }})" wire:confirm="Delete this comment?" class="text-red-500 hover:text-red-600" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-zinc-500">
                                <flux:icon.chat-bubble-left class="w-10 h-10 text-zinc-300 mx-auto mb-2" />
                                No comments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">{{ $comments->links() }}</div>
    </div>
</div>
