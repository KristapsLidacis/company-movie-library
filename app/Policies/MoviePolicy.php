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

    public function show(User $user)
    {
        if($user->tokenCan(AbilitiesEnum::ViewMovies)){
            return true;
        }

        return false;
    }

    public function store(User $user)
    {
        if($user->tokenCan(AbilitiesEnum::CreateMovies)){
            return true;
        }

        return false;
    }

    public function update(User $user)
    {
        if($user->tokenCan(AbilitiesEnum::UpdateMovies)){
            return true;
        }

        return false;
    }

    public function destroy(User $user)
    {
        if($user->tokenCan(AbilitiesEnum::DeleteMovies)){
            return true;
        }

        return false;
    }
}
