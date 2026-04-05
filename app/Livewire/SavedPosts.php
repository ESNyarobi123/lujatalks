<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public')]
#[Title('Saved Inspiration')]
class SavedPosts extends Component
{
    use WithPagination;

    public string $search = '';

    public string $sortBy = 'newest';

    public string $category = '';

    public string $collectionFilter = '';

    public string $newCollectionName = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedCollectionFilter(): void
    {
        $this->resetPage();
    }

    public function createCollection(): void
    {
        $this->validate([
            'newCollectionName' => 'required|string|min:2|max:120',
        ]);

        $max = (int) auth()->user()->collections()->max('sort_order');

        Collection::query()->create([
            'user_id' => auth()->id(),
            'name' => strip_tags($this->newCollectionName),
            'sort_order' => $max + 1,
        ]);

        $this->reset('newCollectionName');
    }

    public function assignCollection(int $postId, ?string $collectionId): void
    {
        if (! auth()->user()->savedPosts()->where('posts.id', $postId)->exists()) {
            return;
        }

        $cid = ($collectionId === null || $collectionId === '' || $collectionId === '0')
            ? null
            : (int) $collectionId;

        if ($cid !== null && ! auth()->user()->collections()->whereKey($cid)->exists()) {
            return;
        }

        auth()->user()->savedPosts()->updateExistingPivot($postId, ['collection_id' => $cid]);
    }

    public function removeSavedPost(int $postId): void
    {
        auth()->user()->savedPosts()->detach($postId);
    }

    public function render()
    {
        $query = auth()->user()->savedPosts()
            ->with(['category', 'user']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('content', 'like', "%{$this->search}%");
            });
        }

        if ($this->category !== '') {
            $query->whereHas('category', fn ($q) => $q->where('slug', $this->category));
        }

        if ($this->collectionFilter === '0') {
            $query->wherePivotNull('collection_id');
        } elseif ($this->collectionFilter !== '') {
            $query->wherePivot('collection_id', (int) $this->collectionFilter);
        }

        $query = match ($this->sortBy) {
            'oldest' => $query->oldest('saved_posts.created_at'),
            'title' => $query->orderBy('title'),
            default => $query->latest('saved_posts.created_at'),
        };

        return view('livewire.saved-posts', [
            'posts' => $query->paginate(9),
            'categories' => Category::has('posts')->orderBy('name')->get(),
            'userCollections' => auth()->user()->collections()->orderBy('sort_order')->get(),
        ]);
    }
}
