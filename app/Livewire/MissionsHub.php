<?php

namespace App\Livewire;

use App\Models\LearningPath;
use App\Models\LearningPathProgress;
use App\Models\LearningPathStep;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Mission paths')]
class MissionsHub extends Component
{
    public function completeStep(int $stepId): void
    {
        $user = auth()->user();
        $step = LearningPathStep::query()->with('learningPath')->findOrFail($stepId);

        if (! $step->learningPath->is_active) {
            return;
        }

        LearningPathProgress::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'learning_path_step_id' => $step->id,
            ],
            ['completed_at' => now()],
        );
    }

    public function uncompleteStep(int $stepId): void
    {
        LearningPathProgress::query()
            ->where('user_id', auth()->id())
            ->where('learning_path_step_id', $stepId)
            ->delete();
    }

    public function render()
    {
        $paths = LearningPath::query()
            ->where('is_active', true)
            ->with(['steps.post'])
            ->orderBy('sort_order')
            ->get();

        $completedStepIds = auth()->user()
            ->learningPathProgress()
            ->pluck('learning_path_step_id')
            ->all();

        return view('livewire.missions-hub', [
            'paths' => $paths,
            'completedStepIds' => $completedStepIds,
        ]);
    }
}
