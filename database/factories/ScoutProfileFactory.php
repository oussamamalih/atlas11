<?php

namespace Database\Factories;

use App\Models\ScoutProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScoutProfile>
 */
class ScoutProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->scout(),
            'organization' => fake()->randomElement([
                'Wydad AC',
                'Raja CA',
                'FUS Rabat',
                'AS FAR',
                'RS Berkane',
                'Moroccan Football Federation (FRMF)',
                'Atlas Stars Talent Agency',
            ]),
            'role_title' => fake()->randomElement([
                'Head of Youth Recruitment',
                'Regional Talent Scout',
                'Academy Director',
                'Technical Scout',
                'Independent Football Consultant',
            ]),
            'location' => fake()->randomElement(['Casablanca', 'Rabat', 'Marrakech', 'Tangier', 'Agadir', 'Fes']),
            'experience_years' => fake()->numberBetween(2, 20),
            'phone' => fake()->phoneNumber(),
            'license_number' => 'FRMF-'.fake()->numberBetween(1000, 9999),
            'bio' => fake()->paragraph(),
        ];
    }
}
