<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Notifications\Notification;

class NewCommentOnYourPostNotification extends Notification
{

    public function __construct(
        public Post $post,
        public Comment $comment,
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
            'message' => $this->comment->user->name.' commented on your article: '.$this->post->title,
            'url' => route('posts.show', $this->post->slug).'#comment-'.$this->comment->id,
            'type' => 'comment_on_post',
        ];
    }
}
