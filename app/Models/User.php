<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'roles' => 'array',
        ];
    }

    /**
     * Get the abilities of the user based on their roles.
     *
     * @return array<string>
     */
    public function getAbilities()
    {
        // Define abilities array
        $abilities = [];

        // Loop through the roles of the user
        foreach ($this->roles ?? [] as $role) {

            // Match the role to the corresponding enum value
            $roleEnum = match ($role) {
                'editor' => RolesEnum::Editor,
                'admin' => RolesEnum::Administrator,
                default => null,
            };

            // If the role enum is not null, merge the abilities
            if ($roleEnum) {
                $abilities = array_merge($abilities, $roleEnum->abilities());
            }
        }

        // Return abilities array
        return $abilities;
    }
}
