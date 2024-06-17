<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieBroadcast extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'movie_id',
        'channel_nr',
        'broadcasts_at',
    ];

    /**
     * Get the movie associated with the movie broadcast.
     *
     * @return BelongsTo
     */
    public function movie(): BelongsTo
    {
        // Define the relationship between MovieBroadcast and Movie
        return $this->belongsTo(Movie::class);
    }
}
