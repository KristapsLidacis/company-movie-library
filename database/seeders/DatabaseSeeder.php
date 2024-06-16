<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if(User::get()->isEmpty()){
            User::factory()->create([
                'name' => 'Editor User',
                'email' => 'editor@example.com',
                'roles' => [
                    'editor'
                ],
            ]);

            User::factory()->create([
                'name' => 'Administrator User',
                'email' => 'admin@example.com',
                'roles' => [
                    'admin'
                ],
            ]);
        }

        Movie::factory(10)
            ->hasMovieBroadcasts(3)
            ->create();
    }
}
