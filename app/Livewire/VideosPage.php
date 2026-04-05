<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Video;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public')]
#[Title('Videos')]
class VideosPage extends Component
{
    use WithPagination;

    #[Url]
    public string $category = '';

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Video::query()
            ->with(['post.category', 'post.user'])
            ->whereHas('post', fn ($q) => $q->where('status', 'published'));

        if ($this->category !== '') {
            $query->whereHas('post.category', fn ($q) => $q->where('slug', $this->category));
        }

        return view('livewire.videos-page', [
            'videos' => $query->latest()->paginate(12),
            'categories' => Category::has('posts')->orderBy('name')->get(),
        ]);
    }
}
