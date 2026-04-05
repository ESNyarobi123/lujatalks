<div class="max-w-5xl mx-auto space-y-8 pb-16">

    {{-- Page Header --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 p-6 sm:p-8 md:p-10 text-white shadow-2xl">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 right-0 w-80 h-80 bg-white/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-400/30 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 border border-white/20 text-white/90 text-sm font-semibold mb-3 sm:mb-4">
                    <flux:icon.flag class="w-4 h-4" /> Personal Growth
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight mb-2">My Goals</h1>
                <p class="text-emerald-200 text-base sm:text-lg max-w-xl">Set targets, track your progress, and celebrate every achievement.</p>
            </div>
            <button wire:click="$toggle('showAddForm')" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 text-white font-bold rounded-full border border-white/20 backdrop-blur shadow-lg transition-colors flex items-center gap-2 flex-shrink-0">
                <flux:icon.plus class="w-4 h-4" /> New Goal
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
        <div class="bg-white rounded-2xl border border-[#282427]/5 p-4 sm:p-5 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-zinc-100 flex items-center justify-center mb-3">
                <flux:icon.list-bullet class="w-5 h-5 text-zinc-500" />
            </div>
            <p class="text-2xl font-black text-[#282427]">{{ $stats['total'] }}</p>
            <p class="text-xs text-[#282427]/50 font-medium">Total Goals</p>
        </div>
        <div class="bg-white rounded-2xl border border-[#282427]/5 p-4 sm:p-5 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mb-3">
                <flux:icon.arrow-trending-up class="w-5 h-5 text-blue-500" />
            </div>
            <p class="text-2xl font-black text-[#282427]">{{ $stats['active'] }}</p>
            <p class="text-xs text-[#282427]/50 font-medium">In Progress</p>
        </div>
        <div class="bg-white rounded-2xl border border-[#282427]/5 p-4 sm:p-5 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
                <flux:icon.trophy class="w-5 h-5 text-emerald-500" />
            </div>
            <p class="text-2xl font-black text-[#282427]">{{ $stats['achieved'] }}</p>
            <p class="text-xs text-[#282427]/50 font-medium">Achieved 🎉</p>
        </div>
        <div class="bg-white rounded-2xl border border-[#282427]/5 p-4 sm:p-5 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
                <flux:icon.chart-bar class="w-5 h-5 text-amber-500" />
            </div>
            <p class="text-2xl font-black text-[#282427]">{{ $stats['avgProgress'] }}%</p>
            <p class="text-xs text-[#282427]/50 font-medium">Avg Progress</p>
        </div>
    </div>

    {{-- Add Goal Form --}}
    @if($showAddForm)
        <div class="bg-white rounded-2xl border-2 border-dashed border-emerald-300 p-5 sm:p-6 md:p-8 shadow-sm">
            <h3 class="text-lg font-bold text-[#282427] mb-5 flex items-center gap-2">
                <flux:icon.sparkles class="w-5 h-5 text-emerald-500" /> Set a New Goal
            </h3>
            <form wire:submit="addGoal" class="flex flex-col gap-4">
                <div>
                    <label class="block text-sm font-bold text-[#282427] mb-2">Goal Title</label>
                    <input wire:model="newGoalTitle" type="text" placeholder="e.g. Read 10 books this month..."
                        class="w-full px-4 py-3 rounded-xl border border-[#282427]/10 text-[#282427] placeholder-[#282427]/40 focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 transition-all" required />
                    @error('newGoalTitle') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#282427] mb-2">Description <span class="text-[#282427]/40 font-normal">(optional)</span></label>
                    <textarea wire:model="newGoalDescription" rows="2" placeholder="Why does this matter to you?"
                        class="w-full px-4 py-3 rounded-xl border border-[#282427]/10 text-[#282427] placeholder-[#282427]/40 focus:ring-2 focus:ring-emerald-500/30 text-sm resize-none"></textarea>
                    @error('newGoalDescription') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-[#282427] mb-2">Category <span class="text-[#282427]/40 font-normal">(optional)</span></label>
                        <input wire:model="newGoalCategory" type="text" placeholder="Faith, Career, Health…"
                            class="w-full px-4 py-3 rounded-xl border border-[#282427]/10 text-[#282427] text-sm" />
                        @error('newGoalCategory') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#282427] mb-2">Target date <span class="text-[#282427]/40 font-normal">(optional)</span></label>
                        <input wire:model="newGoalTargetDate" type="date"
                            class="w-full px-4 py-3 rounded-xl border border-[#282427]/10 text-[#282427] text-sm" />
                        @error('newGoalTargetDate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex items-center gap-3 justify-end">
                    <button wire:click="$toggle('showAddForm')" type="button" class="px-4 py-2 text-sm font-bold text-[#282427]/60 hover:text-[#282427] transition-colors">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white rounded-full font-bold text-sm shadow-lg shadow-emerald-600/25 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <flux:icon.plus class="w-4 h-4" /> Create Goal
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-2 border-b border-[#282427]/10 pb-0.5">
        <button wire:click="$set('filter', 'all')"
            class="px-4 py-2.5 text-sm font-bold rounded-t-lg transition-colors {{ $filter === 'all' ? 'text-emerald-600 border-b-2 border-emerald-600 bg-emerald-50/50' : 'text-[#282427]/50 hover:text-[#282427]' }}">
            All ({{ $stats['total'] }})
        </button>
        <button wire:click="$set('filter', 'active')"
            class="px-4 py-2.5 text-sm font-bold rounded-t-lg transition-colors {{ $filter === 'active' ? 'text-blue-600 border-b-2 border-blue-600 bg-blue-50/50' : 'text-[#282427]/50 hover:text-[#282427]' }}">
            In Progress ({{ $stats['active'] }})
        </button>
        <button wire:click="$set('filter', 'achieved')"
            class="px-4 py-2.5 text-sm font-bold rounded-t-lg transition-colors {{ $filter === 'achieved' ? 'text-emerald-600 border-b-2 border-emerald-600 bg-emerald-50/50' : 'text-[#282427]/50 hover:text-[#282427]' }}">
            Achieved ({{ $stats['achieved'] }})
        </button>
    </div>

    {{-- Goals List --}}
    @if($goals->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($goals as $goal)
                <div wire:key="goal-{{ $goal->id }}"
                    class="group bg-white rounded-2xl border {{ $goal->status === 'achieved' ? 'border-emerald-200 bg-emerald-50/20' : 'border-[#282427]/5' }} p-5 sm:p-6 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex-1">
                            @if($goal->status === 'achieved')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold mb-1">
                                    <flux:icon.check-circle class="w-3 h-3" /> Achieved
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold mb-1">
                                    <flux:icon.arrow-path class="w-3 h-3" /> In Progress
                                </span>
                            @endif
                            <h3 class="text-base sm:text-lg font-bold text-[#282427] {{ $goal->status === 'achieved' ? 'line-through text-[#282427]/40' : '' }} leading-snug mt-1">
                                {{ $goal->title }}
                            </h3>
                            @if($goal->goal_category)
                                <p class="text-xs font-bold text-emerald-600 mt-1">{{ $goal->goal_category }}</p>
                            @endif
                            @if($goal->description)
                                <p class="text-sm text-[#282427]/60 mt-2 leading-relaxed">{{ Str::limit($goal->description, 160) }}</p>
                            @endif
                            @if($goal->target_date)
                                <p class="text-xs text-[#282427]/40 mt-2 flex items-center gap-1">
                                    <flux:icon.calendar class="w-3.5 h-3.5" /> Target: {{ $goal->target_date->format('M j, Y') }}
                                </p>
                            @endif
                        </div>
                        <button wire:click="deleteGoal({{ $goal->id }})" wire:confirm="Delete this goal?"
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-red-300 hover:text-red-500 hover:bg-red-50 transition-colors opacity-0 group-hover:opacity-100">
                            <flux:icon.trash class="w-4 h-4" />
                        </button>
                    </div>

                    {{-- Progress --}}
                    <div class="mb-4">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="font-bold text-[#282427]/50 text-xs">Progress</span>
                            <span class="font-black text-{{ $goal->status === 'achieved' ? 'emerald' : 'blue' }}-600 text-sm">{{ $goal->progress_percentage }}%</span>
                        </div>
                        <div class="h-3 bg-[#EEEBD9] rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 ease-out {{ $goal->status === 'achieved' ? 'bg-gradient-to-r from-emerald-400 to-emerald-600' : 'bg-gradient-to-r from-blue-400 to-blue-600' }}" style="width: {{ $goal->progress_percentage }}%"></div>
                        </div>
                    </div>

                    @if($goal->status !== 'achieved')
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <button wire:click="updateProgress({{ $goal->id }}, -10)" class="w-9 h-9 rounded-xl flex items-center justify-center bg-[#EEEBD9] border border-[#282427]/10 text-[#282427]/50 hover:text-[#282427] hover:bg-[#282427]/5 transition-colors">
                                    <flux:icon.minus class="w-4 h-4" />
                                </button>
                                <button wire:click="updateProgress({{ $goal->id }}, 10)" class="w-9 h-9 rounded-xl flex items-center justify-center bg-emerald-50 border border-emerald-200 text-emerald-600 hover:bg-emerald-100 transition-colors">
                                    <flux:icon.plus class="w-4 h-4" />
                                </button>
                            </div>
                            <span class="text-xs text-[#282427]/30 font-medium">+/- 10%</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-emerald-600">
                            <flux:icon.trophy class="w-5 h-5" />
                            <span class="text-sm font-bold">Goal Completed!</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-16 sm:py-20 bg-white rounded-2xl border border-dashed border-[#282427]/10">
            <div class="w-20 h-20 rounded-2xl bg-emerald-50 flex items-center justify-center mb-6">
                <flux:icon.flag class="w-10 h-10 text-emerald-300" />
            </div>
            <h3 class="text-xl font-bold text-[#282427] mb-2">
                @if($filter !== 'all')
                    No {{ $filter === 'active' ? 'active' : 'achieved' }} goals
                @else
                    Start your growth journey
                @endif
            </h3>
            <p class="text-[#282427]/50 text-center max-w-sm mb-6">
                @if($filter !== 'all')
                    Try switching to a different filter or add a new goal.
                @else
                    Set your first goal and start tracking your progress. Small steps lead to big achievements!
                @endif
            </p>
            <button wire:click="$toggle('showAddForm')" class="px-6 py-3 bg-emerald-600 text-white rounded-full font-bold shadow-lg shadow-emerald-600/25 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                <flux:icon.plus class="w-4 h-4" /> Create Your First Goal
            </button>
        </div>
    @endif
</div>
