<?php

namespace App\Enums;

enum AbilitiesEnum
{
    public const ViewMovies = 'movies:view';
    public const CreateMovies = 'movies:create';
    public const UpdateMovies = 'movies:update';
    public const DeleteMovies = 'movies:delete';
    
    public const ViewMovieBroadcast = 'movie-broadcast:view';
    public const CreateMovieBroadcast = 'movie-broadcast:create';
}
