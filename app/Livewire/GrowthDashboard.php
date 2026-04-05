<?php

namespace App\Livewire;

use App\Models\DailyCheckIn;
use App\Models\LearningPath;
use App\Models\LearningPathProgress;
use App\Models\Like;
use App\Models\Motivation;
use App\Models\Post;
use App\Models\PostRead;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public')]
#[Title('My Space')]
class GrowthDashboard extends Component
{
    use WithPagination;

    public bool $checkTookAction = true;

    public bool $checkRead = true;

    public function mount(): void
    {
        $existing = DailyCheckIn::query()
            ->where('user_id', auth()->id())
            ->whereDate('checked_on', today())
            ->first();

        if ($existing) {
            $this->checkTookAction = $existing->took_action;
            $this->checkRead = $existing->read_something;
        }
    }

    public function submitDailyCheckIn(): void
    {
        DailyCheckIn::query()->updateOrCreate(
            [
                'user_id' => auth()->id(),
                'checked_on' => today(),
            ],
            [
                'took_action' => $this->checkTookAction,
                'read_something' => $this->checkRead,
            ],
        );
    }

    public function toggleSave(int $postId): void
    {
        $user = auth()->user();

        if ($user->savedPosts()->where('post_id', $postId)->exists()) {
            $user->savedPosts()->detach($postId);
        } else {
            $user->savedPosts()->attach($postId);
        }
    }

    public function render()
    {
        $user = auth()->user();

        $savedCount = $user->savedPosts()->count();
        $goalsTotal = $user->goals()->count();
        $goalsActive = $user->goals()->where('status', 'in_progress')->count();
        $goalsCompleted = $user->goals()->where('status', 'achieved')->count();
        $goalsProgress = (int) $user->goals()->where('status', 'in_progress')->avg('progress_percentage');
        $unreadNotifications = $user->unreadNotifications()->count();
        $commentsCount = $user->comments()->count();

        $motivation = Motivation::where('display_date', '<=', today())->orderBy('display_date', 'desc')->first()
            ?? Motivation::latest()->first();

        $activeGoals = $user->goals()->where('status', 'in_progress')->latest()->take(3)->get();

        $feedPosts = Post::with(['user', 'category'])
            ->withCount(['comments', 'likes'])
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(6);

        $savedPosts = $user->savedPosts()->with(['category', 'user'])->latest('saved_posts.created_at')->take(4)->get();

        $savedIds = $user->savedPosts()->pluck('posts.id')->toArray();
        $categoryIds = $user->savedPosts()->pluck('category_id')->filter()->unique()->values()->all();

        $suggestedPosts = Post::query()
            ->with(['user', 'category'])
            ->withCount(['comments', 'likes'])
            ->where('status', 'published')
            ->whereNotIn('id', $savedIds)
            ->when(count($categoryIds) > 0, function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds);
            })
            ->latest('published_at')
            ->take(8)
            ->get();

        if ($suggestedPosts->count() < 4) {
            $suggestedPosts = Post::with(['user', 'category'])
                ->withCount(['comments', 'likes'])
                ->where('status', 'published')
                ->whereNotIn('id', $savedIds)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        $activityComments = $user->comments()
            ->with(['post.category'])
            ->latest()
            ->take(5)
            ->get();

        $activityLikes = Like::query()
            ->where('user_id', $user->id)
            ->where('likeable_type', Post::class)
            ->with('likeable')
            ->latest()
            ->take(5)
            ->get();

        $activitySaves = $user->savedPosts()
            ->with(['category', 'user'])
            ->latest('saved_posts.created_at')
            ->take(5)
            ->get();

        $continueReading = PostRead::query()
            ->where('user_id', $user->id)
            ->orderByDesc('last_opened_at')
            ->take(5)
            ->with(['post' => fn ($q) => $q->with(['user', 'category'])->where('status', 'published')])
            ->get()
            ->map(fn (PostRead $pr) => $pr->post)
            ->filter();

        $streakDays = DailyCheckIn::streakCountForUser($user->id);
        $todayCheckIn = DailyCheckIn::query()
            ->where('user_id', $user->id)
            ->whereDate('checked_on', today())
            ->first();

        $primaryGoal = $user->goals()->where('status', 'in_progress')->oldest()->first();
        $recommendedHeadline = $primaryGoal
            ? 'Based on your goal: '.$primaryGoal->title
            : null;

        $firstPath = LearningPath::query()->where('is_active', true)->with('steps')->orderBy('sort_order')->first();
        $missionProgress = null;
        if ($firstPath && $firstPath->steps->isNotEmpty()) {
            $total = $firstPath->steps->count();
            $done = LearningPathProgress::query()
                ->where('user_id', $user->id)
                ->whereIn('learning_path_step_id', $firstPath->steps->pluck('id'))
                ->count();
            $missionProgress = [
                'path' => $firstPath,
                'done' => $done,
                'total' => $total,
            ];
        }

        return view('livewire.growth-dashboard', [
            'savedCount' => $savedCount,
            'goalsTotal' => $goalsTotal,
            'goalsActive' => $goalsActive,
            'goalsCompleted' => $goalsCompleted,
            'goalsProgress' => $goalsProgress,
            'unreadNotifications' => $unreadNotifications,
            'commentsCount' => $commentsCount,
            'motivation' => $motivation,
            'activeGoals' => $activeGoals,
            'feedPosts' => $feedPosts,
            'savedPosts' => $savedPosts,
            'suggestedPosts' => $suggestedPosts,
            'activityComments' => $activityComments,
            'activityLikes' => $activityLikes,
            'activitySaves' => $activitySaves,
            'continueReading' => $continueReading,
            'streakDays' => $streakDays,
            'todayCheckIn' => $todayCheckIn,
            'recommendedHeadline' => $recommendedHeadline,
            'missionProgress' => $missionProgress,
        ]);
    }
}
