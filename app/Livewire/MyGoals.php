<?php

namespace App\Livewire;

use App\Models\Goal;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('My Goals')]
class MyGoals extends Component
{
    public string $newGoalTitle = '';

    public string $newGoalDescription = '';

    public ?string $newGoalTargetDate = null;

    public string $newGoalCategory = '';

    public string $filter = 'all';

    public bool $showAddForm = false;

    public function addGoal(): void
    {
        $this->validate([
            'newGoalTitle' => 'required|min:3|max:255',
            'newGoalDescription' => 'nullable|max:2000',
            'newGoalTargetDate' => 'nullable|date',
            'newGoalCategory' => 'nullable|max:100',
        ]);

        Goal::create([
            'user_id' => auth()->id(),
            'title' => $this->newGoalTitle,
            'description' => $this->newGoalDescription ? strip_tags($this->newGoalDescription) : null,
            'goal_category' => $this->newGoalCategory ? strip_tags($this->newGoalCategory) : null,
            'target_date' => $this->newGoalTargetDate,
            'status' => 'in_progress',
            'progress_percentage' => 0,
        ]);

        $this->reset(['newGoalTitle', 'newGoalDescription', 'newGoalTargetDate', 'newGoalCategory', 'showAddForm']);
    }

    public function updateProgress(int $goalId, int $amount): void
    {
        $goal = Goal::findOrFail($goalId);

        if ($goal->user_id !== auth()->id()) {
            return;
        }

        $newProgress = max(0, min(100, $goal->progress_percentage + $amount));

        $goal->update([
            'progress_percentage' => $newProgress,
            'status' => $newProgress === 100 ? 'achieved' : 'in_progress',
        ]);
    }

    public function deleteGoal(int $goalId): void
    {
        $goal = Goal::findOrFail($goalId);

        if ($goal->user_id !== auth()->id()) {
            return;
        }

        $goal->delete();
    }

    public function render()
    {
        $goals = match ($this->filter) {
            'active' => auth()->user()->goals()->where('status', 'in_progress')->latest()->get(),
            'achieved' => auth()->user()->goals()->where('status', 'achieved')->latest()->get(),
            default => auth()->user()->goals()->latest()->get(),
        };

        $stats = [
            'total' => auth()->user()->goals()->count(),
            'active' => auth()->user()->goals()->where('status', 'in_progress')->count(),
            'achieved' => auth()->user()->goals()->where('status', 'achieved')->count(),
            'avgProgress' => (int) auth()->user()->goals()->where('status', 'in_progress')->avg('progress_percentage'),
        ];

        return view('livewire.my-goals', [
            'goals' => $goals,
            'stats' => $stats,
        ]);
    }
}
