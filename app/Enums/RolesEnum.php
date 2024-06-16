<?php

namespace App\Enums;

/**
 * Enum for Roles
 *
 * This enum defines various roles for users
 */
enum RolesEnum
{
    case Editor;
    case Administrator;

     /**
     * Get abilities for the current role
     *
     * @return array Array of abilities for the current role
     */
    public function abilities(): array
    {
        return match ($this) {
            self::Editor => [
                AbilitiesEnum::ViewMovies,
                AbilitiesEnum::CreateMovies,
                AbilitiesEnum::UpdateMovies,
                AbilitiesEnum::ViewMovieBroadcast,
            ],
            self::Administrator => [
                AbilitiesEnum::ViewMovies,
                AbilitiesEnum::CreateMovies,
                AbilitiesEnum::UpdateMovies,
                AbilitiesEnum::DeleteMovies,

                AbilitiesEnum::ViewMovieBroadcast,
                AbilitiesEnum::CreateMovieBroadcast,
            ],
            default => [],
        };
    }
}


