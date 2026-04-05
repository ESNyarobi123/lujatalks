<?php

namespace App\Livewire\Admin\Comments;

use App\Models\Comment;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(Comment $comment)
    {
        $comment->delete();
        session()->flash('status', 'Comment deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.comments.index', [
            'comments' => Comment::with(['user', 'post'])
                ->where('content', 'like', '%' . $this->search . '%')
                ->orWhereHas('user', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate(15)
        ]);
    }
}
