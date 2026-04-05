<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class BookmarkButton extends Component
{
    public Post $post;

    public function toggleBookmark(): void
    {
        if (! auth()->check()) {
            $this->redirectRoute('login');

            return;
        }

        $user = auth()->user();

        if ($user->savedPosts()->where('post_id', $this->post->id)->exists()) {
            $user->savedPosts()->detach($this->post->id);
        } else {
            $user->savedPosts()->attach($this->post->id);
        }
    }

    public function render()
    {
        $isSaved = auth()->check()
            ? auth()->user()->savedPosts()->where('post_id', $this->post->id)->exists()
            : false;

        return view('livewire.bookmark-button', [
            'isSaved' => $isSaved,
        ]);
    }
}
