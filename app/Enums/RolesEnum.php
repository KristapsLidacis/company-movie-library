<?php

namespace App\Enums;

enum RolesEnum
{
    case Editor;
    case Administrator;

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


