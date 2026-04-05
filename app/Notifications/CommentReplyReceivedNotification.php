<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Notifications\Notification;

class CommentReplyReceivedNotification extends Notification
{

    public function __construct(
        public Post $post,
        public Comment $reply,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->reply->user->name.' replied to your comment on '.$this->post->title,
            'url' => route('posts.show', $this->post->slug).'#comment-'.$this->reply->id,
            'type' => 'comment_reply',
        ];
    }
}
