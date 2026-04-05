<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Posts Management</h1>
            <p class="text-zinc-500 mt-1">Create, edit, and manage platform articles.</p>
        </div>
        <flux:button variant="primary" href="{{ route('admin.posts.create') }}" icon="plus">Create Post</flux:button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden px-6 py-5">
        
        {{-- Filters & Search --}}
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="flex-1 max-w-sm">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search posts by title or author..." icon="magnifying-glass" />
            </div>
            <div class="flex gap-2">
                <flux:select wire:model.live="status" class="w-40">
                    <option value="all">All Statuses</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </flux:select>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="overflow-x-auto -mx-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-y border-zinc-200/60 bg-zinc-50/50">
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500 cursor-pointer hover:text-zinc-800" wire:click="sortBy('title')">
                            <div class="flex items-center gap-2">
                                Post Details
                                @if($sortField === 'title') <flux:icon.chevron-down class="w-3 h-3 {{ $sortDirection === 'asc' ? 'rotate-180' : '' }}" /> @endif
                            </div>
                        </th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Author</th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500 cursor-pointer hover:text-zinc-800" wire:click="sortBy('status')">
                            Status
                        </th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500 cursor-pointer hover:text-zinc-800" wire:click="sortBy('views_count')">
                            Views
                        </th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500 cursor-pointer hover:text-zinc-800" wire:click="sortBy('created_at')">
                            Date
                        </th>
                        <th class="py-3 px-6 text-right text-xs font-bold uppercase tracking-wider text-zinc-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60">
                    @forelse($posts as $post)
                        <tr wire:key="post-{{ $post->id }}" class="hover:bg-zinc-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    @if($post->feature_image)
                                        <img src="{{ $post->feature_image }}" class="w-12 h-12 rounded-lg object-cover bg-zinc-100 flex-shrink-0" />
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-zinc-100 flex items-center justify-center flex-shrink-0">
                                            <flux:icon.document-text class="w-5 h-5 text-zinc-400" />
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="font-bold text-sm text-zinc-900 hover:text-[#BC6C25] line-clamp-1 block">{{ $post->title }}</a>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs font-medium text-zinc-500">{{ $post->category?->name ?? 'Uncategorized' }}</span>
                                            @if($post->is_trending)
                                                <span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-700 text-[10px] font-bold uppercase tracking-wider">Trending</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-zinc-800 text-white flex items-center justify-center font-bold text-[10px]">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-zinc-700">{{ $post->user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <flux:badge size="sm" :color="$post->status === 'published' ? 'green' : 'zinc'">{{ ucfirst($post->status) }}</flux:badge>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm font-medium text-zinc-600">{{ number_format($post->views_count) }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm font-medium text-zinc-600" title="{{ $post->created_at }}">{{ $post->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <flux:dropdown position="bottom" align="end">
                                    <flux:button variant="ghost" icon="ellipsis-vertical" size="sm" class="!px-2" />
                                    <flux:menu>
                                        <flux:menu.item icon="eye" href="{{ route('posts.show', $post->slug) }}" target="_blank">View on Site</flux:menu.item>
                                        <flux:menu.item icon="pencil-square" href="{{ route('admin.posts.edit', $post) }}">Edit Post</flux:menu.item>
                                        <flux:menu.separator />
                                        <flux:menu.item icon="trash" wire:click="deletePost({{ $post->id }})" wire:confirm="Are you sure you want to delete this post?" class="text-red-500 hover:text-red-600">Delete</flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 px-6 text-center">
                                <div class="flex flex-col items-center justify-center text-zinc-500">
                                    <flux:icon.document-magnifying-glass class="w-12 h-12 mb-4 text-zinc-300" />
                                    <h3 class="text-lg font-bold text-zinc-900">No posts found</h3>
                                    <p class="text-sm max-w-sm mt-1">We couldn't find any posts matching your current filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($posts->hasPages())
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
