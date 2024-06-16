<?php

namespace App\Enums;

/**
 * Enum for Abilities
 *
 * This enum defines various abilities related to movies and movie broadcasts
 */
enum AbilitiesEnum
{
    public const ViewMovies = 'movies:view';
    public const CreateMovies = 'movies:create';
    public const UpdateMovies = 'movies:update';
    public const DeleteMovies = 'movies:delete';
    
    public const ViewMovieBroadcast = 'movie-broadcast:view';
    public const CreateMovieBroadcast = 'movie-broadcast:create';
}
