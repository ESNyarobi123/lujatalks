<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Reported Content</h1>
            <p class="text-zinc-500 mt-1">Review community flags and moderate content to keep Luja safe.</p>
        </div>
    </div>

    @if(session('status'))
        <flux:toast variant="success" text="{{ session('status') }}" heading="Success" />
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden px-6 py-5">
        <div class="flex gap-4 mb-6">
            <flux:select wire:model.live="status" class="w-48">
                <option value="pending">Pending Review</option>
                <option value="resolved">Resolved</option>
                <option value="dismissed">Dismissed</option>
                <option value="all">All Reports</option>
            </flux:select>
        </div>

        <div class="overflow-x-auto -mx-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-y border-zinc-200/60 bg-zinc-50/50">
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Report Details</th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Target Content</th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Status</th>
                        <th class="py-3 px-6 text-right text-xs font-bold uppercase tracking-wider text-zinc-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60">
                    @forelse($reports as $report)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="py-4 px-6">
                                <p class="font-bold text-sm text-zinc-900">Reason: {{ $report->reason }}</p>
                                <p class="text-xs text-zinc-500 mt-1">Reported by {{ $report->user->name ?? 'Unknown' }} &middot; {{ $report->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="py-4 px-6">
                                @if($report->reportable)
                                    <div class="text-xs text-zinc-700 bg-zinc-100 p-2 rounded border border-zinc-200 line-clamp-2 max-w-xs">
                                        <span class="font-bold text-zinc-900">{{ class_basename($report->reportable_type) }}:</span> 
                                        @if(class_basename($report->reportable_type) === 'Comment')
                                            {{ $report->reportable->content }}
                                        @elseif(class_basename($report->reportable_type) === 'Post')
                                            {{ $report->reportable->title }}
                                        @else
                                            Content ID: {{ $report->reportable_id }}
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs italic text-red-500">Content already deleted</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $color = match($report->status) {
                                        'pending' => 'amber',
                                        'resolved' => 'green',
                                        'dismissed' => 'zinc',
                                        default => 'zinc'
                                    };
                                @endphp
                                <flux:badge size="sm" :color="$color">{{ ucfirst($report->status) }}</flux:badge>
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if($report->status === 'pending')
                                    <flux:dropdown position="bottom" align="end">
                                        <flux:button variant="ghost" icon="ellipsis-vertical" size="sm" class="!px-2" />
                                        <flux:menu>
                                            <flux:menu.item icon="check" wire:click="markResolved({{ $report->id }})">Mark as Resolved</flux:menu.item>
                                            <flux:menu.item icon="x-mark" wire:click="dismiss({{ $report->id }})">Dismiss (False Alarm)</flux:menu.item>
                                            @if($report->reportable)
                                                <flux:menu.separator />
                                                <flux:menu.item icon="trash" wire:click="deleteReportable({{ $report->id }})" wire:confirm="Delete the offending content directly?" class="text-red-500 hover:text-red-600">Delete Content</flux:menu.item>
                                            @endif
                                        </flux:menu>
                                    </flux:dropdown>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-zinc-500">
                                <flux:icon.shield-check class="w-10 h-10 text-zinc-300 mx-auto mb-2" />
                                No reports found. Yay!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">{{ $reports->links() }}</div>
    </div>
</div>
