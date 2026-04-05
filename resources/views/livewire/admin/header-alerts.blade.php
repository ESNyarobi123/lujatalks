<flux:dropdown position="bottom" align="end">
    <flux:button variant="ghost" class="!p-2 relative" aria-label="Admin alerts">
        <flux:icon.bell class="h-5 w-5 text-zinc-500" />
        @if($pendingReports > 0)
            <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-[#BC6C25] ring-2 ring-white"></span>
        @endif
    </flux:button>
    <flux:menu class="min-w-[280px] max-w-sm">
        <div class="px-3 py-2 border-b border-zinc-100">
            <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Moderation</p>
            @if($pendingReports > 0)
                <p class="text-sm font-semibold text-zinc-900 mt-1">{{ $pendingReports }} open {{ Str::plural('report', $pendingReports) }}</p>
            @else
                <p class="text-sm text-zinc-500 mt-1">No pending reports</p>
            @endif
        </div>
        @if($recentReports->isNotEmpty())
            <div class="max-h-56 overflow-y-auto py-1">
                @foreach($recentReports as $report)
                    <flux:menu.item href="{{ route('admin.reports.index') }}" wire:navigate class="!items-start !py-2">
                        <span class="text-xs text-zinc-600 line-clamp-2">{{ Str::limit($report->reason, 72) }}</span>
                        <span class="text-[10px] text-zinc-400">{{ $report->created_at->diffForHumans() }}</span>
                    </flux:menu.item>
                @endforeach
            </div>
        @endif
        <flux:menu.separator />
        <flux:menu.item href="{{ route('admin.reports.index') }}" wire:navigate icon="flag">All reports</flux:menu.item>
        <flux:menu.item href="{{ route('admin.comments.index') }}" wire:navigate icon="chat-bubble-left-ellipsis">Comments</flux:menu.item>
    </flux:menu>
</flux:dropdown>
