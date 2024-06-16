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

    public function show(User $user)
    {
        if($user->tokenCan(AbilitiesEnum::ViewMovieBroadcast)){
            return true;
        }

        return false;
    }

    public function store(User $user)
    {
        if($user->tokenCan(AbilitiesEnum::CreateMovieBroadcast)){
            return true;
        }

        return false;
    }
}
