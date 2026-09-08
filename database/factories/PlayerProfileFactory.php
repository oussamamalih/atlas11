<?php

namespace Database\Factories;

use App\Models\PlayerProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlayerProfile>
 */
class PlayerProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->player(),
            'position' => fake()->randomElement(PlayerProfile::POSITIONS),
            'date_of_birth' => fake()->dateTimeBetween('-24 years', '-16 years')->format('Y-m-d'),
            'location' => fake()->randomElement(['Casablanca', 'Rabat', 'Marrakech', 'Tangier', 'Fes', 'Agadir']),
            'preferred_foot' => fake()->randomElement(PlayerProfile::PREFERRED_FEET),
            'height' => fake()->numberBetween(165, 195),
            'weight' => fake()->numberBetween(60, 85),
            'current_club' => fake()->randomElement(['FUS Rabat Academy', 'Wydad AC Youth', 'Raja CA Youth', 'RS Berkane Academy', 'Free Agent']),
            'football_experience' => fake()->paragraph(),
            'bio' => fake()->paragraph(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
