<?php

namespace App\Concerns;

use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLikedBy(?int $userId): bool
    {
        if ($userId === null) {
            return false;
        }

        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function toggleLike(int $userId): bool
    {
        $existing = $this->likes()->where('user_id', $userId)->first();

        if ($existing) {
            $existing->delete();

            return false;
        }

        $this->likes()->create(['user_id' => $userId]);

        return true;
    }

    public function likesCount(): int
    {
        return $this->likes()->count();
    }
}
