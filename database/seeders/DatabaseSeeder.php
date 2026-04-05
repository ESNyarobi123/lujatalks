<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with real Luja Talks content (posts, categories, tags, videos, comments).
     * Pages fetch from the database — run after migrate: `php artisan db:seed` or `php artisan migrate:fresh --seed`.
     */
    public function run(): void
    {
        $this->call(LujaTalksContentSeeder::class);
        $this->call(LearningPathSeeder::class);
    }
}
