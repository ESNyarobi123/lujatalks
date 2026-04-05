<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\YourContentWasLikedNotification;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class LikeButton extends Component
{
    public Model $likeable;

    public string $likeableType;

    public int $likeableId;

    public function mount(Model $likeable): void
    {
        $this->likeable = $likeable;
        $this->likeableType = get_class($likeable);
        $this->likeableId = $likeable->id;
    }

    public function toggleLike(): void
    {
        if (! auth()->check()) {
            $this->redirectRoute('login');

            return;
        }

        $this->likeable = $this->likeable->newQuery()->findOrFail($this->likeableId);

        $wasLiked = $this->likeable->isLikedBy(auth()->id());
        $nowLiked = $this->likeable->toggleLike(auth()->id());

        if ($nowLiked && ! $wasLiked) {
            $this->notifyContentOwner();
        }
    }

    protected function notifyContentOwner(): void
    {
        $actor = auth()->user();

        if ($this->likeable instanceof Post) {
            $this->likeable->loadMissing('user');
            if ($this->likeable->user_id === $actor->id) {
                return;
            }

            $owner = $this->likeable->user;
            if (! $owner->wantsInAppNotification('likes')) {
                return;
            }

            $owner->notify(new YourContentWasLikedNotification(
                $actor,
                'article «'.$this->likeable->title.'»',
                route('posts.show', $this->likeable->slug),
            ));

            return;
        }

        if ($this->likeable instanceof Comment) {
            $this->likeable->loadMissing(['user', 'post']);
            if ($this->likeable->user_id === $actor->id || ! $this->likeable->post) {
                return;
            }

            $owner = $this->likeable->user;
            if (! $owner->wantsInAppNotification('likes')) {
                return;
            }

            $owner->notify(new YourContentWasLikedNotification(
                $actor,
                'comment',
                route('posts.show', $this->likeable->post->slug).'#comment-'.$this->likeable->id,
            ));
        }
    }

    public function render()
    {
        $model = $this->likeable->newQuery()->find($this->likeableId);
        if (! $model) {
            return view('livewire.like-button', [
                'isLiked' => false,
                'count' => 0,
            ]);
        }

        $isLiked = auth()->check() ? $model->isLikedBy(auth()->id()) : false;
        $count = $model->likes()->count();

        return view('livewire.like-button', [
            'isLiked' => $isLiked,
            'count' => $count,
        ]);
    }
}
