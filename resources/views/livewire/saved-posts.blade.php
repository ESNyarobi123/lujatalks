<div class="max-w-5xl mx-auto space-y-8 pb-16">

    {{-- Page Header --}}
    <div>
        <h1 class="text-3xl sm:text-4xl font-black text-[#282427] mb-2">Saved inspiration</h1>
        <p class="text-[#282427]/60 text-base sm:text-lg">Articles and stories you bookmarked — your private library of growth.</p>
    </div>

    {{-- Search + Sort + Category + Collection --}}
    <div class="flex flex-col gap-4">
        <div class="flex flex-col lg:flex-row gap-3">
            <div class="flex-1 relative">
                <flux:icon.magnifying-glass class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-[#282427]/30" />
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search saved posts..."
                    class="w-full pl-12 pr-4 py-3 rounded-xl bg-white border border-[#282427]/10 text-[#282427] placeholder-[#282427]/40 focus:ring-2 focus:ring-[#BC6C25]/30 font-medium shadow-sm" />
            </div>
            <select wire:model.live="collectionFilter"
                class="px-4 py-3 rounded-xl bg-white border border-[#282427]/10 text-[#282427] font-bold text-sm shadow-sm min-w-[180px]">
                <option value="">All collections</option>
                <option value="0">Uncategorized</option>
                @foreach($userCollections as $coll)
                    <option value="{{ $coll->id }}">{{ $coll->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="category"
                class="px-4 py-3 rounded-xl bg-white border border-[#282427]/10 text-[#282427] font-bold text-sm shadow-sm min-w-[160px]">
                <option value="">All categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="sortBy"
                class="px-4 py-3 rounded-xl bg-white border border-[#282427]/10 text-[#282427] font-bold text-sm shadow-sm min-w-[140px]">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="title">By Title</option>
            </select>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-end">
            <div class="flex-1">
                <label class="block text-xs font-bold uppercase tracking-widest text-[#282427]/40 mb-1.5">New collection</label>
                <input wire:model="newCollectionName" type="text" placeholder="e.g. Business ideas, Faith notes…"
                    class="w-full px-4 py-2.5 rounded-xl bg-white border border-[#282427]/10 text-[#282427] text-sm font-medium shadow-sm" />
            </div>
            <flux:button type="button" wire:click="createCollection" variant="primary" class="!bg-[#BC6C25] hover:!bg-[#a35d20] shrink-0">Create</flux:button>
        </div>
    </div>

    {{-- Posts Grid --}}
    @if($posts->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($posts as $post)
                <div class="group bg-white rounded-2xl border border-[#282427]/5 shadow-sm overflow-hidden hover:-translate-y-1 transition-all duration-300 relative">
                    @if($post->feature_image)
                        <a href="{{ route('posts.show', $post->slug) }}" class="block h-40 overflow-hidden">
                            <img src="{{ $post->feature_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        </a>
                    @endif
                    <div class="p-4 sm:p-5">
                        @if($post->category)
                            <span class="text-xs font-bold text-[#BC6C25] uppercase tracking-widest">{{ $post->category->name }}</span>
                        @endif
                        <a href="{{ route('posts.show', $post->slug) }}" class="block mt-1 mb-3">
                            <h3 class="font-bold text-[#282427] group-hover:text-[#BC6C25] transition-colors text-sm sm:text-base line-clamp-2">{{ $post->title }}</h3>
                        </a>
                        <div class="mt-3">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#282427]/35 mb-1">Collection</label>
                            <select
                                wire:change="assignCollection({{ $post->id }}, $event.target.value)"
                                class="w-full text-xs font-bold px-3 py-2 rounded-lg border border-[#282427]/10 bg-[#FDFCFA] text-[#282427]">
                                <option value="0" @selected(!($post->pivot->collection_id ?? null))>Uncategorized</option>
                                @foreach($userCollections as $coll)
                                    <option value="{{ $coll->id }}" @selected((int) ($post->pivot->collection_id ?? 0) === $coll->id)>{{ $coll->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xs text-[#282427]/40">{{ $post->user->name }} · {{ $post->reading_time }} min</span>
                            <button wire:click="removeSavedPost({{ $post->id }})" wire:confirm="Remove from saved?"
                                class="text-xs text-red-400 hover:text-red-600 font-bold transition-colors opacity-0 group-hover:opacity-100">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8 flex justify-center">
            {{ $posts->links() }}
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-16 sm:py-20 bg-white rounded-2xl border border-dashed border-[#282427]/10">
            <div class="w-20 h-20 rounded-2xl bg-blue-50 flex items-center justify-center mb-6">
                <flux:icon.bookmark class="w-10 h-10 text-blue-300" />
            </div>
            <h3 class="text-xl font-bold text-[#282427] mb-2">No saved posts yet</h3>
            <p class="text-[#282427]/50 text-center max-w-sm mb-6">
                @if($search)
                    No saved posts match "{{ $search }}". Try different keywords.
                @else
                    Bookmark articles that inspire you and find them here later.
                @endif
            </p>
            <a href="{{ route('explore') }}" class="px-6 py-3 bg-[#BC6C25] text-white rounded-full font-bold shadow-lg shadow-[#BC6C25]/25 hover:-translate-y-0.5 transition-all">Explore Articles</a>
        </div>
    @endif
</div>
