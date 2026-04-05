<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Collection extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'sort_order',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'saved_posts', 'collection_id', 'post_id')
            ->wherePivot('user_id', $this->user_id)
            ->withPivot(['user_id', 'collection_id'])
            ->withTimestamps();
    }
}
