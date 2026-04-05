<div class="relative max-w-md w-full hidden sm:block">
    <flux:input
        wire:model.live.debounce.300ms="q"
        variant="filled"
        icon="magnifying-glass"
        placeholder="Search posts, users, comments…"
        class="w-full"
        @focus="$dispatch('admin-search-focus')"
    />

    @if(strlen($q) >= 2)
        <div class="absolute left-0 right-0 top-full mt-1 z-50 rounded-xl border border-zinc-200 bg-white shadow-xl max-h-[70vh] overflow-y-auto">
            @if($posts->isEmpty() && $users->isEmpty() && $comments->isEmpty())
                <p class="px-4 py-6 text-sm text-zinc-500 text-center">No matches for "{{ $q }}"</p>
            @else
                @if($posts->isNotEmpty())
                    <p class="px-3 pt-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-zinc-400">Posts</p>
                    <ul class="pb-2">
                        @foreach($posts as $post)
                            <li>
                                <a href="{{ route('admin.posts.edit', $post) }}" wire:navigate class="block px-4 py-2 text-sm text-zinc-800 hover:bg-[#BC6C25]/10 hover:text-[#BC6C25] truncate">
                                    {{ $post->title }}
                                    <span class="block text-xs text-zinc-400">{{ $post->status }} · {{ $post->user?->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if($users->isNotEmpty())
                    <p class="px-3 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-zinc-400 border-t border-zinc-100">Users</p>
                    <ul class="pb-2">
                        @foreach($users as $u)
                            <li>
                                <a href="{{ route('admin.users.index') }}?search={{ urlencode($u->email) }}" wire:navigate class="block px-4 py-2 text-sm text-zinc-800 hover:bg-[#BC6C25]/10 hover:text-[#BC6C25]">
                                    {{ $u->name }}
                                    <span class="block text-xs text-zinc-400 truncate">{{ $u->email }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if($comments->isNotEmpty())
                    <p class="px-3 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-zinc-400 border-t border-zinc-100">Comments</p>
                    <ul class="pb-2">
                        @foreach($comments as $c)
                            <li>
                                <a href="{{ route('admin.comments.index') }}" wire:navigate class="block px-4 py-2 text-sm text-zinc-800 hover:bg-[#BC6C25]/10 hover:text-[#BC6C25]">
                                    <span class="line-clamp-2">{{ Str::limit($c->content, 80) }}</span>
                                    <span class="block text-xs text-zinc-400">{{ $c->user?->name }} · {{ $c->post?->title }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endif
        </div>
    @endif
</div>
