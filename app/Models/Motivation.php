<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivation extends Model
{
    /** @use HasFactory<\Database\Factories\MotivationFactory> */
    use HasFactory;

    protected $fillable = ['quote', 'author', 'message', 'display_date'];

    protected function casts(): array
    {
        return [
            'display_date' => 'date',
        ];
    }
}
