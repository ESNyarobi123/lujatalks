<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;

class QuickSearch extends Component
{
    public string $q = '';

    public function render()
    {
        $posts = collect();
        $users = collect();
        $comments = collect();

        if (strlen($this->q) >= 2) {
            $term = '%'.$this->q.'%';

            $posts = Post::query()
                ->with(['user', 'category'])
                ->where(function ($query) use ($term) {
                    $query->where('title', 'like', $term)
                        ->orWhere('slug', 'like', $term);
                })
                ->latest()
                ->take(6)
                ->get();

            $users = User::query()
                ->where(function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term);
                })
                ->latest()
                ->take(5)
                ->get();

            $comments = Comment::query()
                ->with(['user', 'post'])
                ->where('content', 'like', $term)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('livewire.admin.quick-search', [
            'posts' => $posts,
            'users' => $users,
            'comments' => $comments,
        ]);
    }
}
