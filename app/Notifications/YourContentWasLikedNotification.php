<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Notifications\Notification;

class YourContentWasLikedNotification extends Notification
{

    public function __construct(
        public User $liker,
        public string $contentLabel,
        public string $url,
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
            'message' => $this->liker->name.' liked your '.$this->contentLabel,
            'url' => $this->url,
            'type' => 'like',
        ];
    }
}
