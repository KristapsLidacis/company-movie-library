<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'age_restriction' => $this->faker->randomElement(['7', '12', '16', null]),
            'rating' => $this->faker->randomFloat(1, 0.0, 10.0),
            'premieres_at' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
        ];
    }
}
