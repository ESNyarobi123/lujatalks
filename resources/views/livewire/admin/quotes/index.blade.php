<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Daily Inspiration Quotes</h1>
            <p class="text-zinc-500 mt-1">Manage the motivational quotes displayed daily on the dashboard.</p>
        </div>
        <flux:button variant="primary" wire:click="create" icon="plus">Add Quote</flux:button>
    </div>

    @if(session('status'))
        <flux:toast variant="success" text="{{ session('status') }}" heading="Success" />
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden px-6 py-5">
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="flex-1 max-w-sm">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search authors or quotes..." icon="magnifying-glass" />
            </div>
        </div>

        <div class="space-y-4">
            @forelse($quotes as $quoteItem)
                <div class="border border-zinc-200/60 rounded-xl p-5 hover:border-[#BC6C25]/40 transition-colors flex gap-5">
                    <div class="w-14 h-14 bg-[#BC6C25]/10 text-[#BC6C25] rounded-xl flex items-center justify-center shrink-0">
                        <flux:icon.sparkles class="w-7 h-7" />
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-lg font-bold text-zinc-900 italic">"{{ $quoteItem->quote }}"</p>
                                <p class="text-sm font-semibold text-zinc-600 mt-1">&mdash; {{ $quoteItem->author ?: 'Unknown' }}</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <flux:button size="sm" variant="ghost" icon="pencil-square" wire:click="edit({{ $quoteItem->id }})" />
                                <flux:button size="sm" variant="ghost" icon="trash" wire:click="delete({{ $quoteItem->id }})" wire:confirm="Delete this quote?" class="text-red-500 hover:text-red-600" />
                            </div>
                        </div>
                        @if($quoteItem->message)
                            <div class="mt-3 bg-zinc-50 p-3 rounded-lg text-sm text-zinc-600 border border-zinc-100">
                                <span class="font-bold text-zinc-800 text-xs uppercase tracking-wider block mb-1">Editor's Message:</span>
                                {{ $quoteItem->message }}
                            </div>
                        @endif
                        <div class="mt-3 text-xs text-zinc-400 font-medium">
                            Display Date: <span class="text-zinc-600">{{ $quoteItem->display_date ? $quoteItem->display_date->format('M d, Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-zinc-500">
                    <flux:icon.sparkles class="w-12 h-12 text-zinc-300 mx-auto mb-3" />
                    <p>No quotes found. Start inspiring your community.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-6">{{ $quotes->links() }}</div>
    </div>

    {{-- Create/Edit Modal --}}
    <flux:modal wire:model="showModal" class="md:w-1/2">
        <div class="p-6">
            <h2 class="text-xl font-bold text-zinc-900 mb-6">{{ $editingId ? 'Edit Quote' : 'New Quote' }}</h2>
            
            <form wire:submit="save" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-zinc-900 mb-2">Quote Content <span class="text-red-500">*</span></label>
                    <textarea wire:model="quote" rows="3" class="w-full px-4 py-3 rounded-lg border border-zinc-200 text-zinc-900 focus:ring-2 focus:ring-[#BC6C25] font-sans text-sm resize-none" placeholder="The only way to do great work is to love what you do." required></textarea>
                    @error('quote') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <flux:input wire:model="author" label="Author (Optional)" placeholder="e.g. Steve Jobs" />
                    </div>
                    <div>
                        <flux:input type="date" wire:model="display_date" label="Display Date (Schedule)" required />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-zinc-900 mb-2">Custom Message / Reflection <span class="text-xs font-normal text-zinc-500">(Optional)</span></label>
                    <textarea wire:model="message" rows="2" class="w-full px-4 py-3 rounded-lg border border-zinc-200 text-zinc-900 focus:ring-2 focus:ring-[#BC6C25] font-sans text-sm resize-none" placeholder="Add a short message to go along with this quote..."></textarea>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <flux:button variant="ghost" wire:click="$set('showModal', false)">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">Save Quote</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
