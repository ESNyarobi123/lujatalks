<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Newsletter Subscribers</h1>
            <p class="text-zinc-500 mt-1">Manage your mailing list and export active subscribers.</p>
        </div>
        <flux:button variant="primary" wire:click="exportCsv" icon="arrow-down-tray">Export Active (CSV)</flux:button>
    </div>

    @if(session('status'))
        <flux:toast variant="success" text="{{ session('status') }}" heading="Success" />
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden px-6 py-5">
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="flex-1 max-w-sm">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search emails..." icon="magnifying-glass" />
            </div>
            <div class="w-40">
                <flux:select wire:model.live="status">
                    <option value="all">All</option>
                    <option value="active">Active Only</option>
                    <option value="inactive">Unsubscribed</option>
                </flux:select>
            </div>
        </div>

        <div class="overflow-x-auto -mx-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-y border-zinc-200/60 bg-zinc-50/50">
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Subscriber Email</th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Status</th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Joined Date</th>
                        <th class="py-3 px-6 text-right text-xs font-bold uppercase tracking-wider text-zinc-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60">
                    @forelse($subscribers as $sub)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="py-4 px-6 font-medium text-zinc-900">{{ $sub->email }}</td>
                            <td class="py-4 px-6">
                                <flux:badge size="sm" :color="$sub->is_active ? 'green' : 'zinc'">{{ $sub->is_active ? 'Active' : 'Unsubscribed' }}</flux:badge>
                            </td>
                            <td class="py-4 px-6 text-sm text-zinc-600">{{ $sub->created_at->format('M d, Y g:i A') }}</td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <flux:button size="sm" variant="ghost" icon="arrows-right-left" wire:click="toggleStatus({{ $sub->id }})" title="Toggle Status" />
                                <flux:button size="sm" variant="ghost" icon="trash" wire:click="delete({{ $sub->id }})" wire:confirm="Delete this subscriber?" class="text-red-500 hover:text-red-600" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-zinc-500">No subscribers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">{{ $subscribers->links() }}</div>
    </div>
</div>
