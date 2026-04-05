<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . uniqid(),
            'content' => '<p>' . fake()->paragraphs(3, true) . '</p>',
            'feature_image' => null,
            'is_trending' => false,
            'status' => 'published',
            'published_at' => now(),
            'views_count' => fake()->numberBetween(0, 500),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function trending(): static
    {
        return $this->state(fn () => [
            'is_trending' => true,
        ]);
    }
}
