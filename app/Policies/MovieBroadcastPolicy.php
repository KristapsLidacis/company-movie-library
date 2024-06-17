<?php

namespace App\Policies;

use App\Enums\AbilitiesEnum;
use App\Models\User;

class MovieBroadcastPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user can view a movie broadcast.
     *
     * @return bool True if the user can view the movie broadcast, false otherwise.
     */
    public function show(User $user)
    {
        // Check if the user has the "View Movie Broadcast" ability.
        if($user->tokenCan(AbilitiesEnum::ViewMovieBroadcast)){

            // If the user has the ability, grant access.
            return true;
        }

        // If the user does not have the ability, deny access.
        return false;
    }

    /**
     * Determine if the user can create a movie broadcast.
     *
     * @return bool True if the user can create a movie broadcast, false otherwise.
     */
    public function store(User $user)
    {
        // Check if the user has the "Create Movie Broadcast" ability.
        if($user->tokenCan(AbilitiesEnum::CreateMovieBroadcast)){

            // If the user has the ability, grant access.
            return true;
        }

        // If the user does not have the ability, deny access.
        return false;
    }
}
