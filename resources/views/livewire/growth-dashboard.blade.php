<div class="max-w-5xl mx-auto space-y-8 pb-16">

    {{-- 1. Welcome Block + Daily Motivation --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#282427] via-[#3a3538] to-[#282427] p-6 sm:p-10 text-white shadow-2xl">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-[#BC6C25]/50 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#BC6C25]/30 rounded-full blur-[80px]"></div>
        </div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/10 text-white/80 text-sm font-semibold mb-4">
                <span class="w-2 h-2 rounded-full bg-[#BC6C25] animate-pulse"></span>
                Welcome back
            </div>
            <h1 class="text-2xl sm:text-4xl font-black tracking-tight mb-3">Hey, {{ auth()->user()->name }} 👋</h1>
            @if($motivation)
                <div class="mt-4 p-4 sm:p-5 bg-white/5 rounded-2xl border border-white/10">
                    <p class="text-lg sm:text-xl font-bold text-white/90 leading-relaxed italic">"{{ $motivation->quote }}"</p>
                    <p class="text-sm font-medium text-white/50 mt-3">— {{ $motivation->author ?? 'Luja Talks' }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- 2. Quick Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
        <a href="{{ route('saved') }}" wire:navigate class="group bg-white rounded-2xl border border-[#282427]/5 p-4 sm:p-5 shadow-sm hover:shadow-md hover:border-[#BC6C25]/20 transition-all">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <flux:icon.bookmark class="w-5 h-5 text-blue-500" />
            </div>
            <p class="text-2xl font-black text-[#282427]">{{ $savedCount }}</p>
            <p class="text-xs font-medium text-[#282427]/50 mt-0.5">Saved</p>
        </a>
        <a href="{{ route('goals') }}" wire:navigate class="group bg-white rounded-2xl border border-[#282427]/5 p-4 sm:p-5 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <flux:icon.flag class="w-5 h-5 text-emerald-500" />
            </div>
            <p class="text-2xl font-black text-[#282427]">{{ $goalsActive }}</p>
            <p class="text-xs font-medium text-[#282427]/50 mt-0.5">Active goals</p>
        </a>
        <div class="bg-white rounded-2xl border border-[#282427]/5 p-4 sm:p-5 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center mb-3">
                <flux:icon.trophy class="w-5 h-5 text-violet-500" />
            </div>
            <p class="text-2xl font-black text-[#282427]">{{ $goalsCompleted }}</p>
            <p class="text-xs font-medium text-[#282427]/50 mt-0.5">Completed</p>
        </div>
        <div class="bg-white rounded-2xl border border-[#282427]/5 p-4 sm:p-5 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
                <flux:icon.chart-bar class="w-5 h-5 text-amber-500" />
            </div>
            <p class="text-2xl font-black text-[#282427]">{{ $goalsProgress }}%</p>
            <p class="text-xs font-medium text-[#282427]/50 mt-0.5">Avg progress</p>
        </div>
        <div class="bg-white rounded-2xl border border-[#282427]/5 p-4 sm:p-5 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center mb-3">
                <flux:icon.chat-bubble-left-right class="w-5 h-5 text-sky-500" />
            </div>
            <p class="text-2xl font-black text-[#282427]">{{ $commentsCount }}</p>
            <p class="text-xs font-medium text-[#282427]/50 mt-0.5">Comments</p>
        </div>
        <a href="{{ route('notifications') }}" wire:navigate class="group bg-white rounded-2xl border border-[#282427]/5 p-4 sm:p-5 shadow-sm hover:shadow-md hover:border-rose-200 transition-all">
            <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <flux:icon.bell class="w-5 h-5 text-rose-500" />
            </div>
            <p class="text-2xl font-black text-[#282427]">{{ $unreadNotifications }}</p>
            <p class="text-xs font-medium text-[#282427]/50 mt-0.5">Unread</p>
        </a>
    </div>

    {{-- Hub: check-in, streak, continue reading, missions --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-3xl border border-[#282427]/5 p-6 shadow-sm space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-black text-[#282427] flex items-center gap-2">
                        <flux:icon.calendar class="w-5 h-5 text-amber-500" /> Daily check-in
                    </h2>
                    <p class="text-sm text-[#282427]/55 mt-1">Tiny habits compound. Log today in seconds.</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-xs font-bold uppercase tracking-widest text-[#282427]/40">Streak</p>
                    <p class="text-2xl font-black text-[#BC6C25]">{{ $streakDays }}<span class="text-lg">🔥</span></p>
                </div>
            </div>
            @if($todayCheckIn)
                <p class="text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-xl px-4 py-3">You checked in today — nice work. Update below anytime.</p>
            @endif
            <div class="space-y-3">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" wire:model.live="checkTookAction" class="rounded border-[#282427]/20 text-[#BC6C25] focus:ring-[#BC6C25]/30" />
                    <span class="text-sm font-bold text-[#282427] group-hover:text-[#BC6C25] transition-colors">I took action toward a goal today</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" wire:model.live="checkRead" class="rounded border-[#282427]/20 text-[#BC6C25] focus:ring-[#BC6C25]/30" />
                    <span class="text-sm font-bold text-[#282427] group-hover:text-[#BC6C25] transition-colors">I read or learned something today</span>
                </label>
            </div>
            <flux:button variant="primary" wire:click="submitDailyCheckIn" class="w-full sm:w-auto !bg-[#BC6C25] hover:!bg-[#a35d20]">
                {{ $todayCheckIn ? 'Update check-in' : 'Save check-in' }}
            </flux:button>
        </div>

        <div class="space-y-5">
            @if($continueReading->isNotEmpty())
                <div class="bg-white rounded-3xl border border-[#282427]/5 p-6 shadow-sm">
                    <h2 class="text-lg font-black text-[#282427] flex items-center gap-2 mb-4">
                        <flux:icon.book-open class="w-5 h-5 text-sky-500" /> Continue reading
                    </h2>
                    <ul class="space-y-3">
                        @foreach($continueReading as $cr)
                            <li>
                                <a href="{{ route('posts.show', $cr->slug) }}" wire:navigate class="block font-bold text-[#282427] hover:text-[#BC6C25] text-sm line-clamp-2">{{ $cr->title }}</a>
                                <span class="text-xs text-[#282427]/45">{{ $cr->reading_time }} min @if($cr->category) · {{ $cr->category->name }} @endif</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($missionProgress)
                <div class="bg-gradient-to-br from-[#282427] to-[#3d383b] rounded-3xl p-6 text-white shadow-xl">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-white/50">Mission mode</p>
                            <h3 class="text-lg font-black mt-1">{{ $missionProgress['path']->title }}</h3>
                        </div>
                        <flux:icon.map class="w-8 h-8 text-[#BC6C25]/80 shrink-0" />
                    </div>
                    <div class="h-2 bg-white/10 rounded-full overflow-hidden mb-4">
                        <div class="h-full rounded-full bg-[#BC6C25]" style="width: {{ $missionProgress['total'] > 0 ? round(100 * $missionProgress['done'] / $missionProgress['total']) : 0 }}%"></div>
                    </div>
                    <p class="text-sm text-white/70 mb-4">{{ $missionProgress['done'] }} of {{ $missionProgress['total'] }} steps completed</p>
                    <a href="{{ route('missions') }}" wire:navigate class="inline-flex items-center gap-2 text-sm font-black text-[#BC6C25] hover:text-amber-300 transition-colors">Open mission paths →</a>
                </div>
            @endif
        </div>
    </div>

    {{-- 3. Active Goals (if any) --}}
    @if($activeGoals->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-black text-[#282427] flex items-center gap-2">
                    <flux:icon.flag class="w-5 h-5 text-emerald-500" /> My Goals
                </h2>
                <a href="{{ route('goals') }}" class="text-sm font-bold text-[#BC6C25] hover:underline">View All →</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($activeGoals as $goal)
                    <div class="bg-white rounded-2xl border border-[#282427]/5 p-5 shadow-sm">
                        <h3 class="font-bold text-[#282427] text-sm line-clamp-2 mb-3">{{ $goal->title }}</h3>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-xs font-bold text-[#282427]/40">Progress</span>
                            <span class="font-black text-emerald-600 text-sm">{{ $goal->progress_percentage }}%</span>
                        </div>
                        <div class="h-2.5 bg-[#EEEBD9] rounded-full overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-emerald-600 transition-all duration-500" style="width: {{ $goal->progress_percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Activity --}}
    @if($activityComments->isNotEmpty() || $activityLikes->isNotEmpty() || $activitySaves->isNotEmpty())
        <div>
            <h2 class="text-xl font-black text-[#282427] flex items-center gap-2 mb-4">
                <flux:icon.arrow-path class="w-5 h-5 text-[#BC6C25]" /> Recent activity
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                @if($activityComments->isNotEmpty())
                    <div class="bg-white rounded-2xl border border-[#282427]/5 p-5 shadow-sm">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-[#282427]/40 mb-3">Comments</h3>
                        <ul class="space-y-3">
                            @foreach($activityComments as $ac)
                                <li>
                                    <a href="{{ $ac->post ? route('posts.show', $ac->post->slug).'#comment-'.$ac->id : '#' }}" wire:navigate class="block text-sm text-[#282427] hover:text-[#BC6C25] line-clamp-2">{{ Str::limit($ac->content, 72) }}</a>
                                    <span class="text-[11px] text-[#282427]/40">{{ $ac->post?->title }} · {{ $ac->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($activityLikes->isNotEmpty())
                    <div class="bg-white rounded-2xl border border-[#282427]/5 p-5 shadow-sm">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-[#282427]/40 mb-3">Liked articles</h3>
                        <ul class="space-y-3">
                            @foreach($activityLikes as $lk)
                                @if($lk->likeable instanceof \App\Models\Post)
                                    <li>
                                        <a href="{{ route('posts.show', $lk->likeable->slug) }}" wire:navigate class="text-sm font-bold text-[#282427] hover:text-[#BC6C25] line-clamp-2">{{ $lk->likeable->title }}</a>
                                        <span class="text-[11px] text-[#282427]/40">{{ $lk->created_at->diffForHumans() }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($activitySaves->isNotEmpty())
                    <div class="bg-white rounded-2xl border border-[#282427]/5 p-5 shadow-sm">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-[#282427]/40 mb-3">Saved</h3>
                        <ul class="space-y-3">
                            @foreach($activitySaves as $sv)
                                <li>
                                    <a href="{{ route('posts.show', $sv->slug) }}" wire:navigate class="text-sm font-bold text-[#282427] hover:text-[#BC6C25] line-clamp-2">{{ $sv->title }}</a>
                                    <span class="text-[11px] text-[#282427]/40">{{ $sv->pivot->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- 4. Content Feed --}}
    <div>
        <h2 class="text-xl font-black text-[#282427] flex items-center gap-2 mb-6">
            <flux:icon.fire class="w-5 h-5 text-orange-500" /> Your Feed
        </h2>
        <div class="flex flex-col gap-6">
            @forelse($feedPosts as $post)
                <article x-data="{ showComments: false }" class="bg-white rounded-2xl border border-[#282427]/5 shadow-[0_4px_20px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="p-5 sm:p-6 pb-3">
                        {{-- Author --}}
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-[#282427] text-white flex items-center justify-center font-bold text-sm ring-2 ring-[#BC6C25]/10">
                                {{ substr($post->user->name, 0, 2) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-[#282427] text-sm">{{ $post->user->name }}</h3>
                                <p class="text-xs text-[#282427]/40">
                                    {{ $post->published_at?->diffForHumans() ?? $post->created_at->diffForHumans() }}
                                    @if($post->category)
                                        · <span class="text-[#BC6C25]">{{ $post->category->name }}</span>
                                    @endif
                                    · {{ $post->reading_time }} min read
                                </p>
                            </div>
                        </div>

                        {{-- Content --}}
                        <a href="{{ route('posts.show', $post->slug) }}" class="block mb-3 group">
                            <h2 class="text-xl sm:text-[22px] font-black text-[#282427] group-hover:text-[#BC6C25] transition-colors leading-snug">{{ $post->title }}</h2>
                        </a>
                        <p class="text-[#282427]/70 text-[15px] leading-relaxed mb-4 line-clamp-3">{{ Str::limit(strip_tags($post->content), 250) }}</p>

                        @if($post->feature_image)
                            <a href="{{ route('posts.show', $post->slug) }}" class="block relative w-full aspect-video rounded-xl overflow-hidden bg-[#282427]/5 mb-2">
                                <img src="{{ $post->feature_image }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" alt="{{ $post->title }}" loading="lazy">
                            </a>
                        @endif
                    </div>

                    {{-- Action Bar --}}
                    <div class="px-4 py-2.5 border-t border-[#282427]/5 flex items-center justify-between bg-[#FDFCFA]">
                        <div class="flex items-center gap-1">
                            <livewire:like-button :likeable="$post" :wire:key="'like-feed-'.$post->id" />

                            <button @click="showComments = !showComments"
                                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-bold transition-colors"
                                :class="showComments ? 'text-[#BC6C25] bg-[#BC6C25]/10' : 'text-zinc-500 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5'">
                                <flux:icon.chat-bubble-left class="w-5 h-5" />
                                <span>{{ $post->comments_count }}</span>
                            </button>

                            <button
                                x-data
                                @click="navigator.clipboard.writeText('{{ url('/posts/' . $post->slug) }}'); $el.querySelector('span').textContent = 'Copied!'; setTimeout(() => $el.querySelector('span').textContent = 'Share', 2000)"
                                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-zinc-500 hover:text-[#BC6C25] hover:bg-[#BC6C25]/5 transition-colors text-sm font-bold">
                                <flux:icon.share class="w-5 h-5" />
                                <span class="hidden sm:inline">Share</span>
                            </button>

                            <livewire:bookmark-button :post="$post" :wire:key="'bookmark-feed-'.$post->id" />
                        </div>
                    </div>

                    {{-- Comments --}}
                    <div x-show="showComments" x-transition style="display: none;" class="border-t border-[#282427]/5 bg-[#FAF9F6] p-3 sm:p-4">
                        <livewire:comment-section :post="$post" :wire:key="'comments-dash-'.$post->id" />
                    </div>
                </article>
            @empty
                <div class="flex flex-col items-center justify-center py-16 bg-white rounded-2xl border border-dashed border-[#282427]/10">
                    <flux:icon.newspaper class="w-16 h-16 text-[#282427]/10 mb-4" />
                    <h3 class="text-xl font-bold text-[#282427] mb-2">No posts yet</h3>
                    <p class="text-[#282427]/50 mb-6">The community is just getting started. Check back soon!</p>
                    <a href="{{ route('explore') }}" class="px-6 py-3 bg-[#BC6C25] text-white rounded-full font-bold shadow-lg shadow-[#BC6C25]/25 hover:-translate-y-0.5 transition-all">Explore Content</a>
                </div>
            @endforelse
        </div>
        @if($feedPosts->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $feedPosts->links() }}
            </div>
        @endif
    </div>

    {{-- 5. Saved Content --}}
    @if($savedPosts->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-black text-[#282427] flex items-center gap-2">
                    <flux:icon.bookmark class="w-5 h-5 text-blue-500" /> Saved for Later
                </h2>
                <a href="{{ route('saved') }}" class="text-sm font-bold text-[#BC6C25] hover:underline">View All →</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($savedPosts as $sp)
                    <a href="{{ route('posts.show', $sp->slug) }}" class="group flex gap-4 p-4 bg-white rounded-2xl border border-[#282427]/5 hover:shadow-md transition-all">
                        @if($sp->feature_image)
                            <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="{{ $sp->feature_image }}" class="w-full h-full object-cover" alt="">
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-[#282427] group-hover:text-[#BC6C25] transition-colors text-sm line-clamp-2 mb-1">{{ $sp->title }}</h4>
                            <p class="text-xs text-[#282427]/40">{{ $sp->user->name }} · {{ $sp->reading_time }} min</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- 6. Suggested Content --}}
    @if($suggestedPosts->count() > 0)
        <div>
            <h2 class="text-xl font-black text-[#282427] flex items-center gap-2 mb-4">
                <flux:icon.sparkles class="w-5 h-5 text-[#BC6C25]" />
                @if($recommendedHeadline)
                    <span class="block sm:inline">{{ $recommendedHeadline }}</span>
                @else
                    Suggested for you
                @endif
            </h2>
            @if($recommendedHeadline)
                <p class="text-sm text-[#282427]/50 -mt-2 mb-4">Picked from categories you save and explore — add more bookmarks to sharpen recommendations.</p>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($suggestedPosts as $sug)
                    <article class="group bg-white rounded-2xl border border-[#282427]/5 shadow-sm overflow-hidden hover:-translate-y-0.5 transition-all">
                        @if($sug->feature_image)
                            <a href="{{ route('posts.show', $sug->slug) }}" class="block h-36 overflow-hidden">
                                <img src="{{ $sug->feature_image }}" alt="{{ $sug->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            </a>
                        @endif
                        <div class="p-4">
                            @if($sug->category)
                                <span class="text-xs font-bold text-[#BC6C25] uppercase tracking-widest">{{ $sug->category->name }}</span>
                            @endif
                            <a href="{{ route('posts.show', $sug->slug) }}" class="block mt-1">
                                <h3 class="font-bold text-[#282427] group-hover:text-[#BC6C25] transition-colors text-sm line-clamp-2">{{ $sug->title }}</h3>
                            </a>
                            <p class="text-xs text-[#282427]/40 mt-2">{{ $sug->reading_time }} min read · {{ $sug->likes_count }} likes</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

</div>
