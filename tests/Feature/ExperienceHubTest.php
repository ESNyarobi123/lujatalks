<?php

use App\Livewire\GrowthDashboard;
use App\Livewire\MissionsHub;
use App\Livewire\Posts\Show;
use App\Livewire\SavedPosts;
use App\Models\Collection;
use App\Models\DailyCheckIn;
use App\Models\LearningPath;
use App\Models\LearningPathStep;
use App\Models\Motivation;
use App\Models\Post;
use App\Models\PostRead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('records a post read when an authenticated user opens a published post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'status' => 'published',
        'published_at' => now(),
    ]);

    Livewire::actingAs($user)->test(Show::class, ['slug' => $post->slug]);

    expect(PostRead::query()->where('user_id', $user->id)->where('post_id', $post->id)->exists())->toBeTrue();
});

it('does not create post reads for guests', function () {
    $post = Post::factory()->create([
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->get(route('posts.show', $post->slug))->assertOk();

    expect(PostRead::query()->count())->toBe(0);
});

it('submits a daily check-in from the dashboard', function () {
    $user = User::factory()->create();
    Motivation::factory()->create(['display_date' => today()]);

    Livewire::actingAs($user)->test(GrowthDashboard::class)
        ->set('checkTookAction', true)
        ->set('checkRead', false)
        ->call('submitDailyCheckIn');

    $row = DailyCheckIn::query()->where('user_id', $user->id)->whereDate('checked_on', today())->first();
    expect($row)->not->toBeNull()
        ->and($row->took_action)->toBeTrue()
        ->and($row->read_something)->toBeFalse();
});

it('counts consecutive check-in days as a streak', function () {
    $user = User::factory()->create();
    DailyCheckIn::query()->create([
        'user_id' => $user->id,
        'checked_on' => today(),
        'took_action' => true,
        'read_something' => true,
    ]);
    DailyCheckIn::query()->create([
        'user_id' => $user->id,
        'checked_on' => today()->subDay(),
        'took_action' => true,
        'read_something' => true,
    ]);

    expect(DailyCheckIn::streakCountForUser($user->id))->toBe(2);
});

it('renders the missions page for authenticated users', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get(route('missions'))->assertOk();
});

it('marks a learning path step complete', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['status' => 'published', 'published_at' => now()]);
    $path = LearningPath::query()->create([
        'slug' => 'test-path',
        'title' => 'Test path',
        'description' => null,
        'sort_order' => 0,
        'is_active' => true,
    ]);
    $step = LearningPathStep::query()->create([
        'learning_path_id' => $path->id,
        'sort_order' => 0,
        'step_type' => LearningPathStep::TYPE_POST,
        'title' => null,
        'body' => null,
        'post_id' => $post->id,
    ]);

    Livewire::actingAs($user)->test(MissionsHub::class)
        ->call('completeStep', $step->id);

    expect($user->learningPathProgress()->where('learning_path_step_id', $step->id)->exists())->toBeTrue();
});

it('assigns a saved post to a collection', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['status' => 'published']);
    $user->savedPosts()->attach($post->id);
    $coll = Collection::query()->create([
        'user_id' => $user->id,
        'name' => 'Ideas',
        'sort_order' => 0,
    ]);

    Livewire::actingAs($user)->test(SavedPosts::class)
        ->call('assignCollection', $post->id, (string) $coll->id);

    $pivotCollectionId = $user->savedPosts()->where('posts.id', $post->id)->first()->pivot->collection_id;
    expect((int) $pivotCollectionId)->toBe($coll->id);
});
