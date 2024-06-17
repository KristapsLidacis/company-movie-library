<?php

namespace App\Policies;

use App\Enums\AbilitiesEnum;
use App\Enums\MoviesEnum;
use App\Models\Movie;
use App\Models\User;

class MoviePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user can view a movie.
     *
     * @return bool True if the user can view the movie, false otherwise.
     */
    public function show(User $user)
    {
        // Check if the user has the "View Movies" ability.
        if($user->tokenCan(AbilitiesEnum::ViewMovies)){

            // If the user has the ability, grant access.
            return true;
        }

        // If the user does not have the ability, deny access.
        return false;
    }

    /**
     * Determine if the user can create a movie.
     *
     * @return bool True if the user can create a movie, false otherwise.
     */
    public function store(User $user)
    {
        // Check if the user has the "Create Movies" ability.
        if($user->tokenCan(AbilitiesEnum::CreateMovies)){

            // If the user has the ability, grant access.
            return true;
        }

        // If the user does not have the ability, deny access.
        return false;
    }

    /**
     * Determine if the user can update a movie.
     *
     * @return bool True if the user can update the movie, false otherwise.
     */
    public function update(User $user)
    {
        // Check if the user has the "Update Movies" ability.
        if($user->tokenCan(AbilitiesEnum::UpdateMovies)){

            // If the user has the ability, grant access.
            return true;
        }

        // If the user does not have the ability, deny access.
        return false;
    }

    /**
     * Determine if the user can delete a movie.
     *
     * @return bool True if the user can delete the movie, false otherwise.
     */
    public function destroy(User $user)
    {
        // Check if the user has the "Delete Movies" ability.
        if($user->tokenCan(AbilitiesEnum::DeleteMovies)){

            // If the user has the ability, grant access.
            return true;
        }

        // If the user does not have the ability, deny access.
        return false;
    }
}
