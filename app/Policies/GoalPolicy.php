<?php

namespace App\Policies;

use App\Models\Goal;
use App\Models\User;

class GoalPolicy
{
    /**
     * Any authenticated user can create goals.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only the goal owner can view their goal.
     */
    public function view(User $user, Goal $goal): bool
    {
        return $user->id === $goal->user_id;
    }

    /**
     * Only the goal owner can update.
     */
    public function update(User $user, Goal $goal): bool
    {
        return $user->id === $goal->user_id;
    }

    /**
     * Only the goal owner can delete.
     */
    public function delete(User $user, Goal $goal): bool
    {
        return $user->id === $goal->user_id;
    }
}
