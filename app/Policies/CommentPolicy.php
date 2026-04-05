<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Any authenticated user can create comments.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only the comment author or admins can update.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->isAdmin();
    }

    /**
     * Only the comment author, post author, or admins can delete.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id
            || $user->id === $comment->post->user_id
            || $user->isAdmin();
    }
}
