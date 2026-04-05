<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Platform Settings</h1>
            <p class="text-zinc-500 mt-1">Configure global application settings and preferences.</p>
        </div>
        <flux:button variant="primary" wire:click="$refresh" icon="arrow-path">Refresh</flux:button>
    </div>

    <div class="grid grid-cols-1 gap-8">
        <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden px-6 py-5">
            <h2 class="text-xl font-bold text-zinc-900 mb-4">Under Construction</h2>
            <p class="text-zinc-500">The global settings UI is currently being refined. You will soon be able to change platform names, logos, social media links, default SEO tags, and maintenance mode here.</p>
            <div class="mt-6 flex justify-center py-12">
                <flux:icon.cog-6-tooth class="w-16 h-16 text-zinc-200 animate-[spin_4s_linear_infinite]" />
            </div>
        </div>
    </div>
</div>
