<?php

namespace Database\Seeders;

use App\Models\LearningPath;
use App\Models\LearningPathStep;
use App\Models\Post;
use Illuminate\Database\Seeder;

class LearningPathSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::query()->where('status', 'published')->orderBy('id')->take(3)->get();
        if ($posts->isEmpty()) {
            return;
        }

        $path = LearningPath::query()->updateOrCreate(
            ['slug' => 'start-business'],
            [
                'title' => 'Start a business',
                'description' => 'Read a cornerstone article, take one clarity action, then deepen with more Luja Talks content.',
                'sort_order' => 0,
                'is_active' => true,
            ],
        );

        $path->steps()->delete();

        $order = 0;
        LearningPathStep::query()->create([
            'learning_path_id' => $path->id,
            'sort_order' => $order++,
            'step_type' => LearningPathStep::TYPE_POST,
            'post_id' => $posts->first()->id,
            'title' => null,
            'body' => null,
        ]);

        LearningPathStep::query()->create([
            'learning_path_id' => $path->id,
            'sort_order' => $order++,
            'step_type' => LearningPathStep::TYPE_TASK,
            'title' => 'Define your offer in one line',
            'body' => 'Write one sentence: what you sell or want to build, and who it helps. Keep it in your goals or notes.',
            'post_id' => null,
        ]);

        if ($posts->count() > 1) {
            LearningPathStep::query()->create([
                'learning_path_id' => $path->id,
                'sort_order' => $order++,
                'step_type' => LearningPathStep::TYPE_POST,
                'post_id' => $posts->get(1)->id,
                'title' => null,
                'body' => null,
            ]);
        }

        $path2 = LearningPath::query()->updateOrCreate(
            ['slug' => 'build-discipline'],
            [
                'title' => 'Improve discipline',
                'description' => 'Small repeatable actions — read, reflect, repeat.',
                'sort_order' => 1,
                'is_active' => true,
            ],
        );

        $path2->steps()->delete();

        LearningPathStep::query()->create([
            'learning_path_id' => $path2->id,
            'sort_order' => 0,
            'step_type' => LearningPathStep::TYPE_TASK,
            'title' => 'Pick one non-negotiable',
            'body' => 'Choose a single habit (5–15 min) you will do tomorrow before scrolling. Write it down.',
            'post_id' => null,
        ]);

        LearningPathStep::query()->create([
            'learning_path_id' => $path2->id,
            'sort_order' => 1,
            'step_type' => LearningPathStep::TYPE_TASK,
            'title' => 'Night-before setup',
            'body' => 'Tonight, place everything you need for that habit where you will see it first thing.',
            'post_id' => null,
        ]);
    }
}
