<div class="bg-white rounded-2xl p-4 sm:p-6 md:p-10 shadow-sm border border-[#282427]/5">
    <h3 class="text-xl sm:text-2xl font-black text-[#282427] mb-6" id="comments">Comments ({{ $comments->count() }})</h3>

    @if(session('reported'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
            Thanks — we received your report and will review it.
        </div>
    @endif

    @auth
        <form wire:submit="saveComment" class="mb-8 sm:mb-10">
            <div class="flex items-start gap-3 sm:gap-4">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#282427] text-white flex items-center justify-center font-bold text-sm flex-shrink-0 hidden sm:flex">
                    {{ auth()->user()->initials() }}
                </div>
                <div class="flex-1">
                    <textarea wire:model="content" placeholder="Share your thoughts..." rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-[#282427]/10 text-[#282427] placeholder-[#282427]/40 focus:ring-2 focus:ring-[#BC6C25]/30 focus:border-[#BC6C25] transition-all text-sm resize-none"></textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <div class="mt-3 flex justify-end">
                        <button type="submit" class="px-5 py-2 bg-[#BC6C25] text-white rounded-full font-bold text-sm shadow-md shadow-[#BC6C25]/25 hover:-translate-y-0.5 transition-all">Post Comment</button>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="mb-8 sm:mb-10 p-4 sm:p-6 bg-[#EEEBD9]/50 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border border-[#282427]/5">
            <div>
                <p class="font-bold text-[#282427]">Join the Conversation</p>
                <p class="text-sm text-[#282427]/50">Log in to share your thoughts on this post.</p>
            </div>
            <a href="{{ route('login') }}" class="px-5 py-2 bg-[#BC6C25] text-white rounded-full font-bold text-sm shadow-md flex-shrink-0">Log in to comment</a>
        </div>
    @endauth

    @if($reportingCommentId)
        <div class="mb-8 p-5 rounded-2xl border border-amber-200 bg-amber-50/80">
            <h4 class="font-bold text-[#282427] mb-2">Report comment</h4>
            <p class="text-sm text-[#282427]/60 mb-3">Tell us briefly what is wrong. Our team reviews every report.</p>
            <textarea wire:model="reportReason" rows="3" placeholder="Reason (min 5 characters)"
                class="w-full px-4 py-3 rounded-xl border border-[#282427]/10 text-sm mb-3"></textarea>
            @error('reportReason') <p class="text-red-500 text-xs mb-2">{{ $message }}</p> @enderror
            <div class="flex gap-2 justify-end">
                <button type="button" wire:click="cancelReport" class="px-4 py-2 text-sm font-bold text-[#282427]/60">Cancel</button>
                <button type="button" wire:click="submitReport" class="px-4 py-2 bg-[#282427] text-white rounded-full text-sm font-bold">Submit report</button>
            </div>
        </div>
    @endif

    <div class="space-y-6 sm:space-y-8">
        @forelse($comments as $comment)
            <div id="comment-{{ $comment->id }}" class="flex gap-3 sm:gap-4 scroll-mt-28">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#282427] text-white flex items-center justify-center font-bold text-xs sm:text-sm flex-shrink-0">
                    {{ $comment->user->initials() }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="bg-[#EEEBD9]/40 p-3 sm:p-4 rounded-xl rounded-tl-none">
                        <div class="flex items-center justify-between mb-2 gap-2">
                            <h4 class="font-bold text-[#282427] text-sm">{{ $comment->user->name }}</h4>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <span class="text-xs text-[#282427]/40">{{ $comment->created_at->diffForHumans() }}</span>
                                @auth
                                    @if(auth()->id() === $comment->user_id)
                                        @if($editingId === $comment->id)
                                            <button type="button" wire:click="cancelEdit" class="text-xs font-bold text-[#BC6C25]">Cancel</button>
                                        @else
                                            <button type="button" wire:click="startEdit({{ $comment->id }})" class="text-xs font-bold text-[#282427]/50 hover:text-[#BC6C25]">Edit</button>
                                        @endif
                                        <button type="button" wire:click="deleteComment({{ $comment->id }})" wire:confirm="Delete this comment?" class="text-xs text-red-400 hover:text-red-600 transition-colors">
                                            <flux:icon.trash class="w-3.5 h-3.5" />
                                        </button>
                                    @endif
                                    @if(auth()->id() !== $comment->user_id)
                                        <button type="button" wire:click="openReport({{ $comment->id }})" class="text-xs font-bold text-[#282427]/40 hover:text-amber-600">Report</button>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        @if($editingId === $comment->id)
                            <div class="space-y-2">
                                <textarea wire:model="editContent" rows="3" class="w-full px-3 py-2 rounded-lg border border-[#282427]/10 text-sm"></textarea>
                                @error('editContent') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                                <button type="button" wire:click="saveEdit({{ $comment->id }})" class="text-xs font-bold bg-[#BC6C25] text-white px-3 py-1.5 rounded-full">Save</button>
                            </div>
                        @else
                            <p class="text-[#282427]/80 text-sm whitespace-pre-wrap break-words">{{ $comment->content }}</p>
                        @endif
                    </div>

                    <div class="mt-2 ml-2 flex items-center gap-3 flex-wrap">
                        <livewire:like-button :likeable="$comment" :wire:key="'like-comment-'.$comment->id" />
                        @auth
                            <button type="button" wire:click="setReplyingTo({{ $comment->id }})" class="text-xs font-bold text-[#BC6C25] hover:underline">Reply</button>
                        @endauth
                    </div>

                    @if($replyingTo === $comment->id)
                        <div class="mt-4 ml-4 sm:ml-6">
                            <form wire:submit="saveReply({{ $comment->id }})" class="flex-1">
                                <textarea wire:model="replyContent" placeholder="Write a reply..." rows="2"
                                    class="w-full px-4 py-3 rounded-xl border border-[#282427]/10 text-[#282427] placeholder-[#282427]/40 focus:ring-2 focus:ring-[#BC6C25]/30 text-sm resize-none"></textarea>
                                @error('replyContent') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                <div class="mt-2 flex justify-end gap-2">
                                    <button wire:click="cancelReply" type="button" class="px-4 py-1.5 text-sm font-bold text-[#282427]/60 hover:text-[#282427] transition-colors">Cancel</button>
                                    <button type="submit" class="px-4 py-1.5 bg-[#BC6C25] text-white rounded-full text-sm font-bold shadow-sm">Reply</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if($comment->replies->count() > 0)
                        <div class="mt-4 space-y-4 ml-4 sm:ml-6 border-l-2 border-[#282427]/5 pl-4">
                            @foreach($comment->replies as $reply)
                                <div id="comment-{{ $reply->id }}" class="flex gap-3 scroll-mt-28">
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-[#282427]/80 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                        {{ $reply->user->initials() }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="bg-[#EEEBD9]/30 p-3 rounded-lg rounded-tl-none">
                                            <div class="flex items-center justify-between mb-1 gap-2">
                                                <h4 class="font-bold text-[#282427] text-sm">{{ $reply->user->name }}</h4>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[11px] text-[#282427]/40">{{ $reply->created_at->diffForHumans() }}</span>
                                                    @auth
                                                        @if(auth()->id() === $reply->user_id)
                                                            @if($editingId === $reply->id)
                                                                <button type="button" wire:click="cancelEdit" class="text-[11px] font-bold text-[#BC6C25]">Cancel</button>
                                                            @else
                                                                <button type="button" wire:click="startEdit({{ $reply->id }})" class="text-[11px] font-bold text-[#282427]/50 hover:text-[#BC6C25]">Edit</button>
                                                            @endif
                                                            <button type="button" wire:click="deleteComment({{ $reply->id }})" wire:confirm="Delete this reply?" class="text-red-400 hover:text-red-600">
                                                                <flux:icon.trash class="w-3 h-3" />
                                                            </button>
                                                        @endif
                                                        @if(auth()->id() !== $reply->user_id)
                                                            <button type="button" wire:click="openReport({{ $reply->id }})" class="text-[11px] font-bold text-[#282427]/40 hover:text-amber-600">Report</button>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </div>
                                            @if($editingId === $reply->id)
                                                <div class="space-y-2 mt-2">
                                                    <textarea wire:model="editContent" rows="2" class="w-full px-2 py-2 rounded-lg border border-[#282427]/10 text-sm"></textarea>
                                                    <button type="button" wire:click="saveEdit({{ $reply->id }})" class="text-xs font-bold bg-[#BC6C25] text-white px-3 py-1 rounded-full">Save</button>
                                                </div>
                                            @else
                                                <p class="text-[#282427]/80 text-sm whitespace-pre-wrap break-words">{{ $reply->content }}</p>
                                            @endif
                                        </div>
                                        <div class="mt-2 ml-1">
                                            <livewire:like-button :likeable="$reply" :wire:key="'like-reply-'.$reply->id" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-8 sm:py-12">
                <flux:icon.chat-bubble-left-ellipsis class="w-12 h-12 text-[#282427]/10 mx-auto mb-3" />
                <p class="text-[#282427]/40 font-medium">No comments yet. Be the first to share your thoughts!</p>
            </div>
        @endforelse
    </div>
</div>
