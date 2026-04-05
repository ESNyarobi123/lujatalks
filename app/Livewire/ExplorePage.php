<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public')]
#[Title('Explore')]
class ExplorePage extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $category = '';

    #[Url]
    public string $tag = '';

    #[Url]
    public string $sort = 'latest';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedTag(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Post::query()
            ->with(['category', 'user', 'tags'])
            ->withCount(['comments', 'likes'])
            ->where('status', 'published');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('content', 'like', "%{$this->search}%");
            });
        }

        if ($this->category) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $this->category));
        }

        if ($this->tag) {
            $query->whereHas('tags', fn ($q) => $q->where('slug', $this->tag));
        }

        $query = match ($this->sort) {
            'popular' => $query->orderByDesc('views_count'),
            'trending' => $query->orderByDesc('is_trending')->latest('published_at'),
            default => $query->latest('published_at'),
        };

        $featuredStrip = Post::query()
            ->with(['category', 'user'])
            ->withCount(['comments', 'likes'])
            ->where('status', 'published')
            ->orderByDesc('is_trending')
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('livewire.explore-page', [
            'posts' => $query->paginate(12),
            'categories' => Category::has('posts')->withCount('posts')->orderBy('name')->get(),
            'tags' => Tag::has('posts')->orderBy('name')->get(),
            'featuredStrip' => $featuredStrip,
        ]);
    }
}
