<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public')]
class CategoryPosts extends Component
{
    use WithPagination;

    public Category $category;

    public function mount(string $slug): void
    {
        $this->category = Category::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.category-posts', [
            'posts' => Post::with(['user', 'category', 'tags'])
                ->withCount(['comments', 'likes'])
                ->where('category_id', $this->category->id)
                ->where('status', 'published')
                ->latest('published_at')
                ->paginate(12),
        ])->title($this->category->name.' · Luja Talks');
    }
}
