<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Community Users</h1>
            <p class="text-zinc-500 mt-1">Manage user access and oversee community members.</p>
        </div>
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
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by name or email..." icon="magnifying-glass" />
            </div>
            <div class="w-40">
                <flux:select wire:model.live="role">
                    <option value="all">All Roles</option>
                    <option value="user">Users</option>
                    <option value="admin">Admins</option>
                </flux:select>
            </div>
        </div>

        <div class="overflow-x-auto -mx-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-y border-zinc-200/60 bg-zinc-50/50">
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">User Profile</th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Role</th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Platform Activity</th>
                        <th class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-zinc-500">Joined</th>
                        <th class="py-3 px-6 text-right text-xs font-bold uppercase tracking-wider text-zinc-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60">
                    @forelse($users as $user)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-zinc-800 text-white flex items-center justify-center font-bold shadow-sm">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-zinc-900 flex items-center gap-2">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id()) <span class="bg-zinc-200 text-zinc-600 text-[10px] px-1.5 rounded uppercase">You</span> @endif
                                        </p>
                                        <p class="text-xs text-zinc-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <flux:badge size="sm" :color="$user->isAdmin() ? 'fuchsia' : 'zinc'">{{ ucfirst($user->role) }}</flux:badge>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3 text-xs text-zinc-500">
                                    <span class="flex items-center gap-1" title="Posts created"><flux:icon.document-text class="w-3.5 h-3.5" /> {{ $user->posts_count }}</span>
                                    <span class="flex items-center gap-1" title="Comments made"><flux:icon.chat-bubble-left class="w-3.5 h-3.5" /> {{ $user->comments_count }}</span>
                                    <span class="flex items-center gap-1" title="Saved posts"><flux:icon.bookmark class="w-3.5 h-3.5" /> {{ $user->saved_posts_count }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm text-zinc-600">{{ $user->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <flux:dropdown position="bottom" align="end">
                                    <flux:button variant="ghost" icon="ellipsis-vertical" size="sm" class="!px-2" />
                                    <flux:menu>
                                        @if($user->isAdmin() && $user->id !== auth()->id())
                                            <flux:menu.item icon="arrow-down" wire:click="changeRole({{ $user->id }}, 'user')">Demote to User</flux:menu.item>
                                        @elseif(! $user->isAdmin())
                                            <flux:menu.item icon="arrow-up" wire:click="changeRole({{ $user->id }}, 'admin')">Make Admin</flux:menu.item>
                                            <flux:menu.separator />
                                            <flux:menu.item icon="trash" wire:click="delete({{ $user->id }})" wire:confirm="Delete this user permanently?" class="text-red-500">Delete User</flux:menu.item>
                                        @endif
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-zinc-500">No users found matching current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">{{ $users->links() }}</div>
    </div>
</div>
