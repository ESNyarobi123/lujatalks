<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-2">
                <a href="{{ route('admin.posts.index') }}" class="hover:text-zinc-900 transition-colors">Posts</a>
                <flux:icon.chevron-right class="w-3 h-3" />
                <span class="text-zinc-900">{{ $post && $post->exists ? 'Edit Post' : 'Create Post' }}</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">{{ $post && $post->exists ? 'Edit Post' : 'Create New Post' }}</h1>
        </div>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-16">
        
        {{-- Main Content Column --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 p-6 space-y-6">
                <div>
                    <flux:input wire:model.live.debounce.300ms="title" label="Post Title" placeholder="Enter a captivating title..." required />
                </div>

                <div>
                    <flux:input wire:model="slug" label="URL Slug" placeholder="my-awesome-post" />
                    <p class="text-xs text-zinc-500 mt-1">Leave empty to auto-generate from title. Must be unique.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-zinc-900 mb-2">Content</label>
                    <textarea wire:model="content" rows="12" class="w-full px-4 py-3 rounded-lg border border-zinc-200 text-zinc-900 focus:ring-2 focus:ring-[#BC6C25] focus:border-[#BC6C25] font-sans text-sm resize-y" placeholder="Write your content here... (HTML tags supported)"></textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-zinc-500 mt-2">Note: For a production app, integrate a rich text editor like Trix, Quill, or TinyMCE here.</p>
                </div>
            </div>
        </div>

        {{-- Sidebar Settings Column --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 p-6 space-y-6">
                <h3 class="font-bold text-zinc-900 border-b border-zinc-100 pb-3">Publish Settings</h3>
                
                <div>
                    <flux:select wire:model="status" label="Status">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </flux:select>
                </div>

                <div>
                    <flux:select wire:model="category_id" label="Category" required>
                        <option value="">Select a category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:checkbox wire:model="is_trending" label="Mark as Trending" description="Appears in the trending section of Explore." />
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 p-6 space-y-6">
                <h3 class="font-bold text-zinc-900 border-b border-zinc-100 pb-3">Media</h3>
                
                <div>
                    <flux:input wire:model.live.debounce.500ms="feature_image" label="Featured Image URL" placeholder="https://example.com/image.jpg" />
                </div>

                @if($feature_image)
                    <div class="mt-4 rounded-xl overflow-hidden border border-zinc-200 bg-zinc-50 aspect-video relative">
                        <img src="{{ $feature_image }}" class="absolute inset-0 w-full h-full object-cover" onerror="this.style.display='none'" onload="this.style.display='block'" />
                        <div class="absolute inset-0 flex items-center justify-center text-zinc-400 text-sm font-medium -z-10">Image Preview</div>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 p-6 flex flex-col gap-3 sticky top-24">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ $post && $post->exists ? 'Update Post' : 'Save & Create' }}
                </flux:button>
                <flux:button href="{{ route('admin.posts.index') }}" variant="ghost" class="w-full">Cancel</flux:button>
            </div>
        </div>

    </form>
</div>
