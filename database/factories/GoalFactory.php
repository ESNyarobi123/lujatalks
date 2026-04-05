<?php

namespace Database\Factories;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Goal>
 */
class GoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->paragraph(),
            'goal_category' => fake()->optional()->randomElement(['Growth', 'Faith', 'Career', 'Health']),
            'target_date' => fake()->optional()->dateTimeBetween('now', '+6 months'),
            'status' => 'in_progress',
            'progress_percentage' => fake()->numberBetween(0, 90),
        ];
    }
}
