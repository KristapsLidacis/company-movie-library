<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MovieBroadcast>
 */
class MovieBroadcastFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'movie_id' => Movie::factory(),
            'channel_nr' => $this->faker->numberBetween(1, 100),
            'broadcasts_at' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
        ];
    }
}
