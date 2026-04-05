<div class="max-w-5xl mx-auto space-y-10 pb-16">
    <div>
        <h1 class="text-3xl sm:text-4xl font-black text-[#282427] mb-2">Mission paths</h1>
        <p class="text-[#282427]/60 text-base sm:text-lg max-w-2xl">
            Structured journeys that combine articles and small daily actions. Pick a path, complete steps at your pace, and track progress from <a href="{{ route('dashboard') }}" wire:navigate class="text-[#BC6C25] font-bold hover:underline">My Space</a>.
        </p>
    </div>

    @forelse($paths as $path)
        <section class="bg-white rounded-3xl border border-[#282427]/5 shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-[#282427]/5 bg-gradient-to-br from-[#FDFCFA] to-white">
                <h2 class="text-xl sm:text-2xl font-black text-[#282427]">{{ $path->title }}</h2>
                @if($path->description)
                    <p class="mt-2 text-[#282427]/65 leading-relaxed">{{ $path->description }}</p>
                @endif
                @php
                    $stepsTotal = $path->steps->count();
                    $stepsDone = $path->steps->filter(fn ($s) => in_array($s->id, $completedStepIds, true))->count();
                @endphp
                <div class="mt-4 flex items-center gap-3">
                    <div class="flex-1 h-2.5 bg-[#EEEBD9] rounded-full overflow-hidden max-w-xs">
                        <div class="h-full rounded-full bg-gradient-to-r from-[#BC6C25] to-amber-500 transition-all duration-500"
                            style="width: {{ $stepsTotal > 0 ? round(100 * $stepsDone / $stepsTotal) : 0 }}%"></div>
                    </div>
                    <span class="text-sm font-bold text-[#282427]/50">{{ $stepsDone }} / {{ $stepsTotal }} steps</span>
                </div>
            </div>
            <ol class="divide-y divide-[#282427]/5">
                @foreach($path->steps as $i => $step)
                    @php $done = in_array($step->id, $completedStepIds, true); @endphp
                    <li class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-2xl {{ $done ? 'bg-emerald-100 text-emerald-700' : 'bg-[#282427]/5 text-[#282427]/50' }} flex items-center justify-center font-black text-sm">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-1 min-w-0 space-y-3">
                            @if($step->step_type === \App\Models\LearningPathStep::TYPE_POST && $step->post)
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-[#BC6C25] mb-1">Read</p>
                                    <a href="{{ route('posts.show', $step->post->slug) }}" wire:navigate class="text-lg font-bold text-[#282427] hover:text-[#BC6C25] transition-colors">{{ $step->post->title }}</a>
                                    <p class="text-sm text-[#282427]/50 mt-1">{{ $step->post->reading_time }} min read</p>
                                </div>
                            @else
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-[#BC6C25] mb-1">Action</p>
                                    <h3 class="text-lg font-bold text-[#282427]">{{ $step->title }}</h3>
                                    @if($step->body)
                                        <p class="text-[#282427]/70 mt-2 leading-relaxed whitespace-pre-line">{{ $step->body }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="flex sm:flex-col gap-2 flex-shrink-0">
                            @if($done)
                                <flux:button variant="ghost" size="sm" wire:click="uncompleteStep({{ $step->id }})" class="!text-[#282427]/50">Undo</flux:button>
                            @else
                                <flux:button variant="primary" size="sm" wire:click="completeStep({{ $step->id }})" class="!bg-[#BC6C25] hover:!bg-[#a35d20]">Mark done</flux:button>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>
    @empty
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-dashed border-[#282427]/10">
            <flux:icon.map class="w-16 h-16 text-[#282427]/15 mb-4" />
            <p class="text-[#282427]/60 text-center max-w-md">Mission paths will appear here once content is configured.</p>
        </div>
    @endforelse
</div>
