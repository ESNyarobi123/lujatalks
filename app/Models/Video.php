<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /** @use HasFactory<\Database\Factories\VideoFactory> */
    use HasFactory;

    protected $fillable = ['post_id', 'youtube_url', 'title', 'duration'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
