<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public')]
class AuthorProfilePage extends Component
{
    use WithPagination;

    public User $author;

    public function mount(string $profile_slug): void
    {
        $this->author = User::query()->where('profile_slug', $profile_slug)->firstOrFail();
    }

    public function render()
    {
        $posts = Post::query()
            ->with(['category'])
            ->where('user_id', $this->author->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(12);

        return view('livewire.author-profile-page', [
            'posts' => $posts,
        ])->title($this->author->name.' · Luja Talks');
    }
}
