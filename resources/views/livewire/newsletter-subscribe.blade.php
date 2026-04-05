<div class="relative z-10">
    @if($subscribed)
        <div class="flex flex-col items-center gap-3 py-2">
            <flux:icon.check-circle class="w-12 h-12 text-white" />
            <p class="text-white font-bold text-lg">You are in. Check your inbox soon.</p>
        </div>
    @else
        <form wire:submit="subscribe" class="flex flex-col sm:flex-row max-w-md mx-auto gap-3">
            <div class="flex-1">
                <label for="newsletter-email" class="sr-only">Email</label>
                <input id="newsletter-email" wire:model="email" type="email" placeholder="Enter your email"
                    class="w-full rounded-full px-6 py-3.5 sm:py-4 bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/40" />
                @error('email')
                    <p class="text-white text-sm mt-2 text-center sm:text-left">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" wire:loading.attr="disabled"
                class="bg-white text-[#BC6C25] rounded-full px-8 py-3.5 sm:py-4 font-bold hover:bg-[#EEEBD9] transition-colors shadow-lg disabled:opacity-60">
                <span wire:loading.remove wire:target="subscribe">Subscribe</span>
                <span wire:loading wire:target="subscribe">Sending…</span>
            </button>
        </form>
    @endif
</div>
