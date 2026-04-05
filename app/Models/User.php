<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'google_id', 'password', 'role', 'profile_slug', 'bio', 'notification_prefs'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::creating(function (User $user): void {
            if (empty($user->profile_slug)) {
                $user->profile_slug = static::generateUniqueProfileSlug($user->name);
            }
        });

        static::saving(function (User $user): void {
            if (is_string($user->email) && $user->email !== '') {
                $user->email = Str::lower(trim($user->email));
            }
        });
    }

    /**
     * Generate a unique URL slug for public author pages.
     */
    public static function generateUniqueProfileSlug(string $name): string
    {
        $base = Str::slug($name);
        if ($base === '') {
            $base = 'author';
        }

        $slug = $base;
        $attempt = 0;
        while (static::query()->where('profile_slug', $slug)->exists()) {
            $slug = $base.'-'.Str::lower(Str::random(4));
            $attempt++;
            if ($attempt > 20) {
                $slug = $base.'-'.Str::lower(Str::random(8));
                break;
            }
        }

        return $slug;
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'notification_prefs' => 'array',
        ];
    }

    /**
     * Whether the user wants a given in-app notification channel.
     *
     * @param  'likes'|'comments_on_posts'|'replies'  $channel
     */
    public function wantsInAppNotification(string $channel): bool
    {
        $prefs = $this->notification_prefs;
        if (! is_array($prefs)) {
            return true;
        }

        return ($prefs[$channel] ?? true) !== false;
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the user's initials.
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the user's posts.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the user's comments.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the user's goals.
     */
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    /**
     * Get the user's likes.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the posts saved by the user.
     */
    public function savedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'saved_posts', 'user_id', 'post_id')
            ->withPivot('collection_id')
            ->withTimestamps();
    }

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class)->orderBy('sort_order');
    }

    public function postReads(): HasMany
    {
        return $this->hasMany(PostRead::class);
    }

    public function dailyCheckIns(): HasMany
    {
        return $this->hasMany(DailyCheckIn::class);
    }

    public function learningPathProgress(): HasMany
    {
        return $this->hasMany(LearningPathProgress::class);
    }
}
