<?php

use App\Livewire\BookmarkButton;
use App\Livewire\CategoryPosts;
use App\Livewire\CommentSection;
use App\Livewire\ExplorePage;
use App\Livewire\GlobalSearch;
use App\Livewire\GrowthDashboard;
use App\Livewire\HomePage;
use App\Livewire\LikeButton;
use App\Livewire\MyGoals;
use App\Livewire\Notifications;
use App\Livewire\Posts\Show;
use App\Livewire\SavedPosts;
use App\Livewire\VideosPage;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Motivation;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

// ===========================
// PUBLIC PAGE TESTS
// ===========================

it('renders the homepage', function () {
    Motivation::factory()->create(['display_date' => today()]);
    $this->get(route('home'))->assertOk();
});

it('renders the explore page', function () {
    $this->get(route('explore'))->assertOk();
});

it('renders the videos page', function () {
    $this->get(route('videos'))->assertOk();
});

it('renders the search page', function () {
    $this->get(route('search'))->assertOk();
});

it('renders a category page', function () {
    $category = Category::factory()->create();
    $this->get(route('categories.show', $category->slug))->assertOk();
});

it('renders a published post', function () {
    $post = Post::factory()->create([
        'status' => 'published',
        'published_at' => now(),
    ]);
    $this->get(route('posts.show', $post->slug))->assertOk();
});

it('increments view count on post visit', function () {
    $post = Post::factory()->create([
        'status' => 'published',
        'views_count' => 5,
    ]);
    $this->get(route('posts.show', $post->slug));

    expect($post->fresh()->views_count)->toBe(6);
});

// ===========================
// AUTH REQUIRED PAGES
// ===========================

it('redirects unauthenticated users from dashboard', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

it('renders dashboard for authenticated users', function () {
    $user = User::factory()->create();
    Motivation::factory()->create(['display_date' => today()]);

    $this->actingAs($user)->get(route('dashboard'))->assertOk();
});

it('renders saved posts for authenticated users', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get(route('saved'))->assertOk();
});

it('renders goals for authenticated users', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get(route('goals'))->assertOk();
});

it('renders notifications for authenticated users', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get(route('notifications'))->assertOk();
});

// ===========================
// ADMIN AUTHORIZATION
// ===========================

it('blocks non-admin users from admin panel', function () {
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user)->get(route('admin.posts.index'))->assertForbidden();
});

it('allows admin users to access admin panel', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin)->get(route('admin.posts.index'))->assertOk();
});

// ===========================
// LIKE SYSTEM
// ===========================

it('allows users to like a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['status' => 'published']);

    $this->actingAs($user);
    Livewire::test(LikeButton::class, ['likeable' => $post])
        ->call('toggleLike');

    expect($post->likes()->count())->toBe(1);
});

it('allows users to unlike a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['status' => 'published']);
    $post->likes()->create(['user_id' => $user->id]);

    $this->actingAs($user);
    Livewire::test(LikeButton::class, ['likeable' => $post])
        ->call('toggleLike');

    expect($post->likes()->count())->toBe(0);
});

// ===========================
// BOOKMARK SYSTEM
// ===========================

it('allows users to bookmark a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['status' => 'published']);

    $this->actingAs($user);
    Livewire::test(BookmarkButton::class, ['post' => $post])
        ->call('toggleBookmark');

    expect($user->savedPosts()->count())->toBe(1);
});

it('allows users to remove a bookmark', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['status' => 'published']);
    $user->savedPosts()->attach($post->id);

    $this->actingAs($user);
    Livewire::test(BookmarkButton::class, ['post' => $post])
        ->call('toggleBookmark');

    expect($user->savedPosts()->count())->toBe(0);
});

// ===========================
// COMMENT SYSTEM
// ===========================

it('allows users to post comments', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['status' => 'published']);

    $this->actingAs($user);
    Livewire::test(CommentSection::class, ['post' => $post])
        ->set('content', 'Great article!')
        ->call('saveComment');

    expect(Comment::count())->toBe(1);
    expect(Comment::first()->content)->toBe('Great article!');
});

it('allows users to reply to comments', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['status' => 'published']);
    $comment = Comment::factory()->create([
        'post_id' => $post->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);
    Livewire::test(CommentSection::class, ['post' => $post])
        ->set('replyContent', 'I agree!')
        ->call('saveReply', $comment->id);

    expect(Comment::count())->toBe(2);
    expect(Comment::whereNotNull('parent_id')->first()->content)->toBe('I agree!');
});

it('notifies the post author when another user comments', function () {
    $author = User::factory()->create();
    $commenter = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $author->id,
        'status' => 'published',
    ]);

    $this->actingAs($commenter);
    Livewire::test(CommentSection::class, ['post' => $post])
        ->set('content', 'Inspired!')
        ->call('saveComment');

    expect($author->fresh()->unreadNotifications()->count())->toBe(1);
});

it('notifies the post author when another user likes their post', function () {
    $author = User::factory()->create();
    $liker = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $author->id,
        'status' => 'published',
    ]);

    $this->actingAs($liker);
    Livewire::test(LikeButton::class, ['likeable' => $post])
        ->call('toggleLike');

    expect($author->fresh()->unreadNotifications()->count())->toBe(1);
});

it('does not notify when authors like their own post', function () {
    $author = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $author->id,
        'status' => 'published',
    ]);

    $this->actingAs($author);
    Livewire::test(LikeButton::class, ['likeable' => $post])
        ->call('toggleLike');

    expect($author->fresh()->unreadNotifications()->count())->toBe(0);
});

it('does not notify post author when they disabled like notifications', function () {
    $author = User::factory()->create([
        'notification_prefs' => ['likes' => false],
    ]);
    $liker = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $author->id,
        'status' => 'published',
    ]);

    $this->actingAs($liker);
    Livewire::test(LikeButton::class, ['likeable' => $post])
        ->call('toggleLike');

    expect($author->fresh()->unreadNotifications()->count())->toBe(0);
});

// ===========================
// GOALS SYSTEM
// ===========================

it('allows users to create goals', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    Livewire::test(MyGoals::class)
        ->set('showAddForm', true)
        ->set('newGoalTitle', 'Read 12 books')
        ->call('addGoal');

    expect($user->goals()->count())->toBe(1);
});

it('allows users to update goal progress', function () {
    $user = User::factory()->create();
    $goal = $user->goals()->create([
        'title' => 'Test goal',
        'status' => 'in_progress',
        'progress_percentage' => 50,
    ]);

    $this->actingAs($user);
    Livewire::test(MyGoals::class)
        ->call('updateProgress', $goal->id, 10);

    expect($goal->fresh()->progress_percentage)->toBe(60);
});

it('marks goal as achieved at 100%', function () {
    $user = User::factory()->create();
    $goal = $user->goals()->create([
        'title' => 'Test goal',
        'status' => 'in_progress',
        'progress_percentage' => 90,
    ]);

    $this->actingAs($user);
    Livewire::test(MyGoals::class)
        ->call('updateProgress', $goal->id, 10);

    $goal->refresh();
    expect($goal->progress_percentage)->toBe(100);
    expect($goal->status)->toBe('achieved');
});

// ===========================
// READING TIME
// ===========================

it('calculates reading time for posts', function () {
    $post = Post::factory()->create([
        'content' => str_repeat('word ', 400), // 400 words = 2 min
    ]);

    expect($post->reading_time)->toBe(2);
});

// ===========================
// ROLE SYSTEM
// ===========================

it('identifies admin users correctly', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);

    expect($admin->isAdmin())->toBeTrue();
    expect($user->isAdmin())->toBeFalse();
});

// ===========================
// XSS PROTECTION
// ===========================

it('sanitizes post content output', function () {
    $post = Post::factory()->create([
        'content' => '<p>Safe</p><script>alert("xss")</script><b>Bold</b>',
    ]);

    expect($post->sanitized_content)->not->toContain('<script>');
    expect($post->sanitized_content)->toContain('<p>Safe</p>');
    expect($post->sanitized_content)->toContain('<b>Bold</b>');
});
