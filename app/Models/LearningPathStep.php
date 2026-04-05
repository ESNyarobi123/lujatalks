<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningPathStep extends Model
{
    public const TYPE_POST = 'post';

    public const TYPE_TASK = 'task';

    protected $fillable = [
        'learning_path_id',
        'sort_order',
        'step_type',
        'title',
        'body',
        'post_id',
    ];

    public function learningPath(): BelongsTo
    {
        return $this->belongsTo(LearningPath::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function progressRecords(): HasMany
    {
        return $this->hasMany(LearningPathProgress::class);
    }
}
