<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Tags Management</h1>
            <p class="text-zinc-500 mt-1">Organize content using flexible metadata tags.</p>
        </div>
        <flux:button variant="primary" wire:click="create" icon="plus">New Tag</flux:button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden px-6 py-5">
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="flex-1 max-w-sm">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search tags..." icon="magnifying-glass" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse($tags as $tag)
                <div class="border border-zinc-200/60 rounded-xl p-4 hover:border-[#BC6C25]/40 transition-colors flex items-center justify-between group">
                    <div>
                        <p class="font-bold text-sm text-zinc-900 flex items-center gap-1.5">
                            <flux:icon.hashtag class="w-3.5 h-3.5 text-zinc-400" /> {{ $tag->name }}
                        </p>
                        <p class="text-xs text-zinc-500 mt-0.5">{{ $tag->posts_count }} posts</p>
                    </div>
                    <div class="flex opacity-0 group-hover:opacity-100 transition-opacity gap-1">
                        <flux:button size="sm" variant="ghost" icon="pencil-square" wire:click="edit({{ $tag->id }})" class="!w-8 !h-8" />
                        <flux:button size="sm" variant="ghost" icon="trash" wire:click="delete({{ $tag->id }})" wire:confirm="Delete this tag?" class="!w-8 !h-8 text-red-500 hover:text-red-600" />
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-zinc-500">No tags found.</div>
            @endforelse
        </div>
        
        <div class="mt-6">{{ $tags->links() }}</div>
    </div>

    {{-- Create/Edit Modal --}}
    <flux:modal wire:model="showModal" class="md:w-1/3">
        <div class="p-6">
            <h2 class="text-xl font-bold text-zinc-900 mb-6">{{ $editingId ? 'Edit Tag' : 'New Tag' }}</h2>
            
            <form wire:submit="save" class="space-y-5">
                <div>
                    <flux:input wire:model.live.debounce.300ms="name" label="Name" placeholder="e.g. Technology" required />
                </div>
                <div>
                    <flux:input wire:model="slug" label="Slug" placeholder="technology" required />
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <flux:button variant="ghost" wire:click="$set('showModal', false)">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">Save Tag</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
