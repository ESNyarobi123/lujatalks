<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Notifications\CommentReplyReceivedNotification;
use App\Notifications\NewCommentOnYourPostNotification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CommentSection extends Component
{
    public Post $post;

    public string $content = '';

    public ?int $replyingTo = null;

    public string $replyContent = '';

    public ?int $editingId = null;

    public string $editContent = '';

    public string $reportReason = '';

    public ?int $reportingCommentId = null;

    public function saveComment(): void
    {
        $this->validate(['content' => 'required|min:2|max:2000']);

        if (! auth()->check()) {
            $this->redirectRoute('login');

            return;
        }

        $key = 'comment:'.auth()->id();

        if (RateLimiter::tooManyAttempts($key, 8)) {
            $this->addError('content', 'Too many comments. Please wait a moment.');

            return;
        }

        RateLimiter::hit($key, 60);

        $comment = Comment::create([
            'post_id' => $this->post->id,
            'user_id' => auth()->id(),
            'content' => strip_tags($this->content),
        ]);

        $comment->load('user');
        $this->post->loadMissing('user');

        if ($this->post->user_id !== auth()->id() && $this->post->user->wantsInAppNotification('comments_on_posts')) {
            $this->post->user->notify(new NewCommentOnYourPostNotification($this->post, $comment));
        }

        $this->content = '';
    }

    public function setReplyingTo(Comment $comment): void
    {
        $this->replyingTo = $comment->id;
        $this->replyContent = '';
    }

    public function cancelReply(): void
    {
        $this->replyingTo = null;
        $this->replyContent = '';
    }

    public function saveReply(int $parentId): void
    {
        $this->validate(['replyContent' => 'required|min:2|max:2000']);

        if (! auth()->check()) {
            $this->redirectRoute('login');

            return;
        }

        $parentComment = Comment::findOrFail($parentId);

        $key = 'comment:'.auth()->id();

        if (RateLimiter::tooManyAttempts($key, 8)) {
            $this->addError('replyContent', 'Too many comments. Please wait a moment.');

            return;
        }

        RateLimiter::hit($key, 60);

        $reply = Comment::create([
            'post_id' => $this->post->id,
            'user_id' => auth()->id(),
            'parent_id' => $parentComment->id,
            'content' => strip_tags($this->replyContent),
        ]);

        $reply->load('user');

        if ($parentComment->user_id !== auth()->id() && $parentComment->user->wantsInAppNotification('replies')) {
            $parentComment->user->notify(new CommentReplyReceivedNotification($this->post, $reply));
        }

        $this->replyingTo = null;
        $this->replyContent = '';
    }

    public function startEdit(int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);

        if (auth()->id() !== $comment->user_id) {
            return;
        }

        $this->editingId = $comment->id;
        $this->editContent = $comment->content;
    }

    public function cancelEdit(): void
    {
        $this->editingId = null;
        $this->editContent = '';
    }

    public function saveEdit(int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);

        if (auth()->id() !== $comment->user_id) {
            return;
        }

        $this->validate(['editContent' => 'required|min:2|max:2000']);

        $comment->update([
            'content' => strip_tags($this->editContent),
        ]);

        $this->cancelEdit();
    }

    public function deleteComment(int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);

        if (auth()->id() !== $comment->user_id && ! auth()->user()->isAdmin()) {
            return;
        }

        $comment->delete();
    }

    public function openReport(int $commentId): void
    {
        if (! auth()->check()) {
            $this->redirectRoute('login');

            return;
        }

        $this->reportingCommentId = $commentId;
        $this->reportReason = '';
    }

    public function cancelReport(): void
    {
        $this->reportingCommentId = null;
        $this->reportReason = '';
    }

    public function submitReport(): void
    {
        if (! auth()->check()) {
            $this->redirectRoute('login');

            return;
        }

        $this->validate([
            'reportReason' => 'required|string|min:5|max:500',
        ]);

        $comment = Comment::findOrFail($this->reportingCommentId);

        $key = 'report:'.auth()->id();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('reportReason', 'Too many reports. Please try again later.');

            return;
        }
        RateLimiter::hit($key, 300);

        Report::create([
            'user_id' => auth()->id(),
            'reportable_id' => $comment->id,
            'reportable_type' => Comment::class,
            'reason' => strip_tags($this->reportReason),
            'status' => 'pending',
        ]);

        $this->cancelReport();
        Session::flash('reported', true);
    }

    public function render()
    {
        $comments = Comment::where('post_id', $this->post->id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user', 'likes'])
            ->latest()
            ->get();

        return view('livewire.comment-section', [
            'comments' => $comments,
        ]);
    }
}
