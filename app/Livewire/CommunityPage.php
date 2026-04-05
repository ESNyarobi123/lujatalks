<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public')]
#[Title('Community')]
class CommunityPage extends Component
{
    use WithPagination;

    public function render()
    {
        $comments = Comment::query()
            ->with(['user', 'post.category'])
            ->whereNull('parent_id')
            ->whereHas('post', fn ($q) => $q->where('status', 'published'))
            ->latest()
            ->paginate(15);

        return view('livewire.community-page', [
            'comments' => $comments,
        ]);
    }
}
