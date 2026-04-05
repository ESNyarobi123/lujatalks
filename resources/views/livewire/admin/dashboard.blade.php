<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Dashboard Overview</h1>
            <p class="text-zinc-500 mt-1">Welcome back to Luja Talks headquarters. Here's what's happening today.</p>
        </div>
        <div class="flex items-center gap-3">
            <flux:button variant="primary" href="{{ route('admin.posts.create') }}" icon="plus">New Post</flux:button>
            <flux:button href="{{ route('home') }}" icon="arrow-top-right-on-square" target="_blank">View Site</flux:button>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        {{-- Users --}}
        <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 p-6 flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold text-zinc-500">Total Users</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <p class="text-3xl font-black text-zinc-900">{{ number_format($stats['users']) }}</p>
                    <span class="text-sm font-semibold text-emerald-600 flex items-center gap-1">
                        <flux:icon.arrow-trending-up class="w-3 h-3" /> +12%
                    </span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                <flux:icon.users class="w-6 h-6 text-blue-600" />
            </div>
        </div>

        {{-- Posts --}}
        <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 p-6 flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold text-zinc-500">Total Posts</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <p class="text-3xl font-black text-zinc-900">{{ number_format($stats['posts']) }}</p>
                    <span class="text-sm font-medium text-zinc-400 text-xs">({{ $stats['published_posts'] }} pub)</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center">
                <flux:icon.document-text class="w-6 h-6 text-purple-600" />
            </div>
        </div>

        {{-- Views --}}
        <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 p-6 flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold text-zinc-500">Total Views</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <p class="text-3xl font-black text-zinc-900">{{ number_format($stats['total_views']) }}</p>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                <flux:icon.eye class="w-6 h-6 text-amber-600" />
            </div>
        </div>

        {{-- Comments --}}
        <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 p-6 flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold text-zinc-500">Comments</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <p class="text-3xl font-black text-zinc-900">{{ number_format($stats['comments']) }}</p>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center">
                <flux:icon.chat-bubble-left-ellipsis class="w-6 h-6 text-emerald-600" />
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Recent Posts List --}}
        <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden">
            <div class="p-6 border-b border-zinc-100 flex items-center justify-between">
                <h3 class="font-bold text-zinc-900">Recent Posts</h3>
                <a href="{{ route('admin.posts.index') }}" class="text-sm font-semibold text-[#BC6C25] hover:underline">View All</a>
            </div>
            <div class="divide-y divide-zinc-100">
                @foreach($recentPosts as $post)
                    <div class="p-4 sm:px-6 hover:bg-zinc-50 flex items-center justify-between">
                        <div class="flex items-start gap-4">
                            @if($post->feature_image)
                                <img src="{{ $post->feature_image }}" alt="" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-zinc-100 flex items-center justify-center">
                                    <flux:icon.photo class="w-5 h-5 text-zinc-400" />
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="font-bold text-sm text-zinc-900 hover:text-[#BC6C25] line-clamp-1">{{ $post->title }}</a>
                                <div class="flex items-center gap-2 mt-1 text-xs text-zinc-500">
                                    <span>{{ $post->category?->name ?? 'Uncategorized' }}</span>
                                    <span>&middot;</span>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <flux:badge size="sm" :color="$post->status === 'published' ? 'green' : 'zinc'">{{ ucfirst($post->status) }}</flux:badge>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Users List --}}
        <div class="bg-white rounded-2xl shadow-sm border border-zinc-200/60 overflow-hidden">
            <div class="p-6 border-b border-zinc-100 flex items-center justify-between">
                <h3 class="font-bold text-zinc-900">New Users</h3>
                <a href="#" class="text-sm font-semibold text-[#BC6C25] hover:underline">View All</a>
            </div>
            <div class="divide-y divide-zinc-100">
                @foreach($recentUsers as $user)
                    <div class="p-4 sm:px-6 hover:bg-zinc-50 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-zinc-800 text-white flex items-center justify-center font-bold text-xs">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="font-bold text-sm text-zinc-900">{{ $user->name }}</p>
                                <p class="text-xs text-zinc-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-zinc-400">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
