<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyCheckIn extends Model
{
    protected $fillable = [
        'user_id',
        'checked_on',
        'took_action',
        'read_something',
    ];

    protected function casts(): array
    {
        return [
            'checked_on' => 'date',
            'took_action' => 'boolean',
            'read_something' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Consecutive days with a check-in, counting backward from today or (if today is empty) from yesterday.
     */
    public static function streakCountForUser(int $userId): int
    {
        $today = CarbonImmutable::today();
        $hasToday = static::query()->where('user_id', $userId)->whereDate('checked_on', $today)->exists();
        $cursor = $hasToday ? $today : $today->subDay();

        if (! static::query()->where('user_id', $userId)->whereDate('checked_on', $cursor)->exists()) {
            return 0;
        }

        $streak = 0;

        for ($i = 0; $i < 400; $i++) {
            if (static::query()->where('user_id', $userId)->whereDate('checked_on', $cursor)->exists()) {
                $streak++;
                $cursor = $cursor->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }
}
