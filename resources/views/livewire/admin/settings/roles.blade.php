<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Roles and Access</h1>
            <p class="text-zinc-500 mt-1">Manage system privileges and administrative layers.</p>
        </div>
        <flux:button variant="primary" href="{{ route('admin.users.index') }}" icon="users">Go to Community Users</flux:button>
    </div>

    <div class="grid grid-cols-1 gap-8">
        <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden px-6 py-5">
            <h2 class="text-xl font-bold text-zinc-900 mb-4">Granular Roles UI Coming Soon</h2>
            <p class="text-zinc-500">Currently, Luja has two primary roles: <strong>User</strong> and <strong>Admin</strong>. You can change a user's role directly from the <a href="{{ route('admin.users.index') }}" class="text-[#BC6C25] font-semibold hover:underline">Community Users</a> page.</p>
            <p class="text-zinc-500 mt-2">More granular roles (Editor, Moderator, Analyst) and detailed RBAC configuration will be built into this interface soon.</p>
            <div class="mt-8 flex justify-center py-6">
                <flux:icon.shield-check class="w-20 h-20 text-zinc-200" />
            </div>
        </div>
    </div>
</div>
