<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'stats' => [
                'users' => User::count(),
                'posts' => Post::count(),
                'published_posts' => Post::published()->count(),
                'comments' => Comment::count(),
                'categories' => Category::count(),
                'total_views' => Post::sum('views_count'),
            ],
            'recentUsers' => User::latest()->take(5)->get(),
            'recentPosts' => Post::with('user', 'category')->latest()->take(5)->get(),
            'topPosts' => Post::orderByDesc('views_count')->take(5)->get(),
        ]);
    }
}
