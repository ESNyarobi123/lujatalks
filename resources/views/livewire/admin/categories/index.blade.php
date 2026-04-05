<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Category Management</h1>
            <p class="text-zinc-500 mt-1">Organize posts by managing platforms categories.</p>
        </div>
        <flux:button variant="primary" wire:click="create" icon="plus">New Category</flux:button>
    </div>

    @if(session('status'))
        <flux:toast variant="success" text="{{ session('status') }}" heading="Success" />
    @endif
    
    @if(session('error'))
        <flux:toast variant="danger" text="{{ session('error') }}" heading="Error" />
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden px-6 py-5">
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="flex-1 max-w-sm">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search categories..." icon="magnifying-glass" />
            </div>
        </div>

        <div class="overflow-x-auto -mx-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-y border-zinc-200/60 bg-zinc-50/50">
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Name & Details</th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Usage Count</th>
                        <th class="py-3 px-6 text-right text-xs font-bold uppercase tracking-wider text-zinc-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60">
                    @forelse($categories as $category)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="py-4 px-6">
                                <p class="font-bold text-sm text-zinc-900">{{ $category->name }}</p>
                                <p class="text-xs text-zinc-500 mt-1 line-clamp-1 max-w-md">{{ $category->description ?? 'No description' }}</p>
                                <p class="text-[10px] text-zinc-400 mt-0.5">/category/{{ $category->slug }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-bold">
                                    <flux:icon.document-text class="w-3.5 h-3.5" />
                                    {{ $category->posts_count }} posts
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <flux:button size="sm" variant="ghost" icon="pencil-square" wire:click="edit({{ $category->id }})" />
                                <flux:button size="sm" variant="ghost" icon="trash" wire:click="delete({{ $category->id }})" wire:confirm="Delete this category?" class="text-red-500 hover:text-red-600" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-zinc-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">{{ $categories->links() }}</div>
    </div>

    {{-- Create/Edit Modal --}}
    <flux:modal wire:model="showModal" class="md:w-1/2">
        <div class="p-6">
            <h2 class="text-xl font-bold text-zinc-900 mb-6">{{ $editingId ? 'Edit Category' : 'New Category' }}</h2>
            
            <form wire:submit="save" class="space-y-5">
                <div>
                    <flux:input wire:model.live.debounce.300ms="name" label="Name" placeholder="e.g. Technology" required />
                </div>
                <div>
                    <flux:input wire:model="slug" label="Slug" placeholder="technology" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-zinc-900 mb-2">Description <span class="text-xs font-normal text-zinc-500">(Optional)</span></label>
                    <textarea wire:model="description" rows="3" class="w-full px-4 py-3 rounded-lg border border-zinc-200 text-zinc-900 focus:ring-2 focus:ring-[#BC6C25] font-sans text-sm resize-none"></textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <flux:button variant="ghost" wire:click="$set('showModal', false)">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">Save Category</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
