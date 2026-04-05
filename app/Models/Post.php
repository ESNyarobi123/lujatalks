<?php

namespace App\Models;

use App\Concerns\HasLikes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, HasLikes;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'content',
        'feature_image', 'is_trending', 'status', 'published_at', 'views_count',
    ];

    protected function casts(): array
    {
        return [
            'is_trending' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Estimated reading time in minutes.
     */
    protected function readingTime(): Attribute
    {
        return Attribute::get(function (): int {
            $wordCount = str_word_count(strip_tags($this->content ?? ''));

            return max(1, (int) ceil($wordCount / 200));
        });
    }

    public function scopePublished($query)
    {
        $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        $query->where('status', 'draft');
    }

    public function scopeTrending($query)
    {
        $query->where('is_trending', true);
    }

    /**
     * Get sanitized content (strip dangerous tags).
     */
    public function getSanitizedContentAttribute(): string
    {
        return strip_tags($this->content ?? '', '<p><br><b><strong><i><em><u><ul><ol><li><h2><h3><h4><h5><h6><a><img><blockquote><pre><code><hr><table><thead><tbody><tr><th><td><span><div><figure><figcaption>');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function savedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_posts', 'post_id', 'user_id')->withTimestamps();
    }

    public function postReads(): HasMany
    {
        return $this->hasMany(PostRead::class);
    }
}
