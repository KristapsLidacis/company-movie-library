<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'age_restriction',
        'rating',
        'premieres_at',
    ];

    public function movieBroadcasts(): HasMany
    {
        return $this->hasMany(MovieBroadcast::class)->whereDate('broadcasts_at', '>=', Carbon::now())->orderBy('broadcasts_at');
    }
}
