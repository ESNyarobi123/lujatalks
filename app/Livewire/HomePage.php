<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Motivation;
use App\Models\Post;
use App\Models\Video;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public')]
#[Title('Luja Talks')]
class HomePage extends Component
{
    use WithPagination;

    public function render()
    {
        $motivation = Motivation::where('display_date', '<=', today())->orderBy('display_date', 'desc')->first()
            ?? Motivation::latest()->first();

        $featuredPostsRaw = Post::with(['category', 'user'])
            ->withCount(['comments', 'likes'])
            ->where('status', 'published')
            ->orderByDesc('is_trending')
            ->latest()
            ->take(3)
            ->get();

        $featuredPost = $featuredPostsRaw->first();
        $sidePosts = $featuredPostsRaw->skip(1)->take(2);
        $excludeIds = $featuredPostsRaw->pluck('id')->toArray();

        $latestPosts = Post::with(['category', 'user'])
            ->withCount(['comments', 'likes'])
            ->whereNotIn('id', $excludeIds)
            ->where('status', 'published')
            ->latest()
            ->paginate(6);

        $categories = Category::has('posts')->withCount('posts')->get();
        $videos = Video::with('post.user')->latest()->take(3)->get();

        return view('livewire.home-page', [
            'motivation' => $motivation,
            'featuredPost' => $featuredPost,
            'sidePosts' => $sidePosts,
            'latestPosts' => $latestPosts,
            'categories' => $categories,
            'videos' => $videos,
        ]);
    }
}
