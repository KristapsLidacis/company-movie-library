<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'age_restriction',
        'rating',
        'premieres_at',
    ];

    /**
     * Get the movie broadcasts associated with the movie.
     *
     * @return HasMany
     */
    public function movieBroadcasts(): HasMany
    {
        // Get the movie broadcasts where the broadcasts at date is greater than or equal to today
        // and order them by broadcasts at date
        return $this->hasMany(MovieBroadcast::class)->whereDate('broadcasts_at', '>=', Carbon::now())->orderBy('broadcasts_at');
    }
}
