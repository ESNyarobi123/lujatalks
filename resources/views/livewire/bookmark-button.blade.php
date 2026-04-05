<button wire:click="toggleBookmark" class="group flex items-center gap-1.5 px-3 py-2 rounded-lg transition-colors {{ $isSaved ? 'text-blue-500 bg-blue-50' : 'text-zinc-500 hover:text-blue-500 hover:bg-blue-50' }}">
    @if($isSaved)
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z" clip-rule="evenodd"/></svg>
    @else
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/></svg>
    @endif
    <span class="text-sm font-bold hidden sm:inline">{{ $isSaved ? 'Saved' : 'Save' }}</span>
</button>
