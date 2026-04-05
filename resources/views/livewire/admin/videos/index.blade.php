<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Video Library</h1>
            <p class="text-zinc-500 mt-1">Manage platform video content and links.</p>
        </div>
        <flux:button variant="primary" wire:click="create" icon="plus">Add Video</flux:button>
    </div>

    @if(session('status'))
        <flux:toast variant="success" text="{{ session('status') }}" heading="Success" />
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden px-6 py-5">
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="flex-1 max-w-sm">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search videos..." icon="magnifying-glass" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($videos as $video)
                @php
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $video->youtube_url, $match);
                    $youtubeId = $match[1] ?? '';
                @endphp
                <div class="flex flex-col bg-white rounded-2xl border border-zinc-200/60 overflow-hidden group hover:border-[#BC6C25]/40 transition-colors shadow-sm">
                    <div class="aspect-video bg-zinc-100 relative">
                        <img src="https://img.youtube.com/vi/{{ $youtubeId }}/mqdefault.jpg" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity" alt="{{ $video->title }}">
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="w-12 h-12 bg-black/60 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <flux:icon.play class="w-5 h-5 text-white ml-0.5" />
                            </div>
                        </div>
                        @if($video->duration)
                            <span class="absolute bottom-2 right-2 px-1.5 py-0.5 bg-black/80 text-white text-[10px] font-bold rounded">{{ $video->duration }}</span>
                        @endif
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-sm text-zinc-900 border-b border-white hover:text-[#BC6C25] truncate mb-1" title="{{ $video->title }}">{{ $video->title }}</h3>
                        <div class="flex items-center gap-1 text-[11px] text-zinc-500 mb-4">
                            @if($video->post)
                                <flux:icon.link class="w-3 h-3" /> Attached to: <span class="font-semibold text-zinc-700 truncate block">{{ $video->post->title }}</span>
                            @else
                                <span class="italic">Standalone video</span>
                            @endif
                        </div>
                        <div class="mt-auto flex justify-between items-center pt-3 border-t border-zinc-100">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-zinc-400">{{ $video->created_at->format('M d, Y') }}</span>
                            <div class="flex items-center gap-2">
                                <button wire:click="edit({{ $video->id }})" class="text-zinc-400 hover:text-[#BC6C25] transition-colors"><flux:icon.pencil-square class="w-4 h-4" /></button>
                                <button wire:click="delete({{ $video->id }})" wire:confirm="Delete this video?" class="text-zinc-400 hover:text-red-500 transition-colors"><flux:icon.trash class="w-4 h-4" /></button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <flux:icon.play-circle class="w-12 h-12 text-zinc-300 mx-auto mb-3" />
                    <p class="text-zinc-500">No videos found. Start building your library.</p>
                </div>
            @endforelse
        </div>
        
        @if($videos->hasPages())
            <div class="mt-6">{{ $videos->links() }}</div>
        @endif
    </div>

    {{-- Create/Edit Modal --}}
    <flux:modal wire:model="showModal" class="md:w-1/2">
        <div class="p-6">
            <h2 class="text-xl font-bold text-zinc-900 mb-6">{{ $editingId ? 'Edit Video' : 'Add Video' }}</h2>
            
            <form wire:submit="save" class="space-y-5">
                <div>
                    <flux:input wire:model="title" label="Video Title" placeholder="e.g. Masterclass on Success" required />
                </div>
                <div>
                    <flux:input wire:model="youtube_url" label="YouTube URL" placeholder="https://youtube.com/watch?v=..." required />
                    @error('youtube_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <flux:input wire:model="duration" label="Duration (Optional)" placeholder="e.g. 14:30" />
                    </div>
                    <div>
                        <flux:select wire:model="post_id" label="Attach to Post (Optional)">
                            <option value="">-- Standalone Video --</option>
                            @foreach($posts as $post)
                                <option value="{{ $post->id }}">{{ $post->title }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-8">
                    <flux:button variant="ghost" wire:click="$set('showModal', false)">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">Save Video</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
