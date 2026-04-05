<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Video;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Search')]
class GlobalSearch extends Component
{
    #[Url]
    public string $q = '';

    public function render()
    {
        $posts = collect();
        $categories = collect();
        $tags = collect();
        $videos = collect();

        if (strlen($this->q) >= 2) {
            $term = $this->q;

            $posts = Post::with(['user', 'category'])
                ->withCount(['comments', 'likes'])
                ->where('status', 'published')
                ->where(function ($query) use ($term) {
                    $query->where('title', 'like', "%{$term}%")
                        ->orWhere('content', 'like', "%{$term}%");
                })
                ->latest()
                ->take(20)
                ->get();

            $categories = Category::where('name', 'like', "%{$term}%")->get();
            $tags = Tag::where('name', 'like', "%{$term}%")->get();

            $videos = Video::with(['post.user', 'post.category'])
                ->where(function ($query) use ($term) {
                    $query->where('title', 'like', "%{$term}%")
                        ->orWhere('youtube_url', 'like', "%{$term}%")
                        ->orWhereHas('post', function ($q) use ($term) {
                            $q->where('title', 'like', "%{$term}%")
                                ->where('status', 'published');
                        });
                })
                ->latest()
                ->take(12)
                ->get();
        }

        return view('livewire.global-search', [
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
            'videos' => $videos,
        ]);
    }
}
