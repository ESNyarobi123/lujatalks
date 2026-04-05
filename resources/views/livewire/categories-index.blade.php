<div class="max-w-5xl mx-auto space-y-10 pb-20 px-4 sm:px-0">
    <div class="text-center pt-6 sm:pt-10">
        <h1 class="text-4xl sm:text-5xl font-black text-[#282427] mb-3">Categories</h1>
        <p class="text-lg text-[#282427]/60 max-w-xl mx-auto">Pick a lane for your growth — education, faith, success, and more.</p>
    </div>

    @if($categories->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-dashed border-[#282427]/10">
            <flux:icon.folder-open class="w-16 h-16 text-[#282427]/15 mb-4" />
            <p class="text-[#282427]/50 font-medium">Categories will appear once stories are published.</p>
            <a href="{{ route('explore') }}" wire:navigate class="mt-6 px-6 py-3 bg-[#BC6C25] text-white rounded-full font-bold shadow-lg shadow-[#BC6C25]/25">Browse all posts</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            @foreach($categories as $cat)
                <a href="{{ route('categories.show', $cat->slug) }}" wire:navigate
                    class="group flex items-center justify-between gap-4 p-6 sm:p-8 bg-white rounded-3xl border border-[#282427]/5 shadow-sm hover:shadow-xl hover:border-[#BC6C25]/25 hover:-translate-y-0.5 transition-all duration-300">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="w-14 h-14 rounded-2xl bg-[#BC6C25]/10 flex items-center justify-center flex-shrink-0 group-hover:bg-[#BC6C25]/20 transition-colors">
                            <flux:icon.tag class="w-7 h-7 text-[#BC6C25]" />
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-xl font-black text-[#282427] group-hover:text-[#BC6C25] transition-colors truncate">{{ $cat->name }}</h2>
                            <p class="text-sm text-[#282427]/50 mt-1">{{ $cat->posts_count }} {{ Str::plural('article', $cat->posts_count) }}</p>
                        </div>
                    </div>
                    <flux:icon.chevron-right class="w-6 h-6 text-[#282427]/30 group-hover:text-[#BC6C25] flex-shrink-0" />
                </a>
            @endforeach
        </div>
    @endif
</div>
