<div class="max-w-3xl mx-auto space-y-6 pb-16">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl sm:text-4xl font-black text-[#282427] mb-1">Notifications</h1>
            <p class="text-[#282427]/60">Stay updated on activity.</p>
        </div>
        @if($unreadCount > 0)
            <button wire:click="markAllAsRead" class="px-4 py-2 text-sm font-bold text-[#BC6C25] hover:bg-[#BC6C25]/10 rounded-xl transition-colors">
                Mark all read
            </button>
        @endif
    </div>

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-2 border-b border-[#282427]/10 pb-0.5">
        <button wire:click="$set('filter', 'all')"
            class="px-4 py-2.5 text-sm font-bold rounded-t-lg transition-colors {{ $filter === 'all' ? 'text-[#BC6C25] border-b-2 border-[#BC6C25] bg-[#BC6C25]/5' : 'text-[#282427]/50 hover:text-[#282427]' }}">
            All
        </button>
        <button wire:click="$set('filter', 'unread')"
            class="px-4 py-2.5 text-sm font-bold rounded-t-lg transition-colors flex items-center gap-2 {{ $filter === 'unread' ? 'text-[#BC6C25] border-b-2 border-[#BC6C25] bg-[#BC6C25]/5' : 'text-[#282427]/50 hover:text-[#282427]' }}">
            Unread
            @if($unreadCount > 0)
                <span class="w-5 h-5 rounded-full bg-[#BC6C25] text-white text-[11px] font-bold flex items-center justify-center">{{ $unreadCount }}</span>
            @endif
        </button>
        <button wire:click="$set('filter', 'read')"
            class="px-4 py-2.5 text-sm font-bold rounded-t-lg transition-colors {{ $filter === 'read' ? 'text-[#BC6C25] border-b-2 border-[#BC6C25] bg-[#BC6C25]/5' : 'text-[#282427]/50 hover:text-[#282427]' }}">
            Read
        </button>
    </div>

    {{-- Notifications List --}}
    @if($notifications->count() > 0)
        <div class="flex flex-col gap-3">
            @foreach($notifications as $notification)
                <div class="group flex items-start gap-4 p-4 sm:p-5 rounded-2xl border transition-all
                    {{ $notification->read_at ? 'bg-white border-[#282427]/5' : 'bg-[#BC6C25]/5 border-[#BC6C25]/10' }}">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                        {{ $notification->read_at ? 'bg-[#282427]/5' : 'bg-[#BC6C25]/10' }}">
                        <flux:icon.bell class="w-5 h-5 {{ $notification->read_at ? 'text-[#282427]/30' : 'text-[#BC6C25]' }}" />
                    </div>
                    <div class="flex-1 min-w-0">
                        @if(! empty($notification->data['url'] ?? null))
                            <a href="{{ $notification->data['url'] }}" wire:navigate class="text-sm {{ $notification->read_at ? 'text-[#282427]/60' : 'text-[#282427] font-bold' }} hover:text-[#BC6C25] block leading-snug">
                                {{ $notification->data['message'] ?? 'New notification' }}
                            </a>
                        @else
                            <p class="text-sm {{ $notification->read_at ? 'text-[#282427]/60' : 'text-[#282427] font-bold' }}">
                                {{ $notification->data['message'] ?? 'New notification' }}
                            </p>
                        @endif
                        <p class="text-xs text-[#282427]/40 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        @if(!$notification->read_at)
                            <button wire:click="markAsRead('{{ $notification->id }}')" class="text-xs font-bold text-[#BC6C25] hover:underline">Read</button>
                        @endif
                        <button wire:click="deleteNotification('{{ $notification->id }}')" class="text-xs text-red-400 hover:text-red-600">
                            <flux:icon.trash class="w-3.5 h-3.5" />
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-16 sm:py-20 bg-white rounded-2xl border border-dashed border-[#282427]/10">
            <div class="w-20 h-20 rounded-2xl bg-amber-50 flex items-center justify-center mb-6">
                <flux:icon.bell-slash class="w-10 h-10 text-amber-300" />
            </div>
            <h3 class="text-xl font-bold text-[#282427] mb-2">
                @if($filter === 'unread') No unread notifications
                @elseif($filter === 'read') No read notifications
                @else All caught up!
                @endif
            </h3>
            <p class="text-[#282427]/50 text-center max-w-sm">
                @if($filter === 'all')
                    You're all caught up. New notifications will appear here.
                @else
                    Try switching to a different filter.
                @endif
            </p>
        </div>
    @endif
</div>
