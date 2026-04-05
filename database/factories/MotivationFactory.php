<?php

namespace Database\Factories;

use App\Models\Motivation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Motivation>
 */
class MotivationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quote' => fake()->sentence(10),
            'author' => fake()->name(),
            'message' => fake()->paragraph(),
            'display_date' => today(),
        ];
    }
}
