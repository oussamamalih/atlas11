<?php

namespace Database\Factories;

use App\Models\PlayerProfile;
use App\Models\ScoutingInterest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScoutingInterest>
 */
class ScoutingInterestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scout_id' => User::factory()->scout(),
            'player_profile_id' => PlayerProfile::factory(),
            'status' => ScoutingInterest::STATUS_PENDING,
            'message' => fake()->paragraph(),
        ];
    }

    public function viewed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ScoutingInterest::STATUS_VIEWED,
        ]);
    }

    public function contacted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ScoutingInterest::STATUS_CONTACTED,
        ]);
    }

    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ScoutingInterest::STATUS_CLOSED,
        ]);
    }
}
