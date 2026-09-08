<?php

namespace Tests\Feature;

use App\Models\PlayerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get('/scout/search');
        $response->assertRedirect('/login');
    }

    public function test_players_cannot_access_scout_search(): void
    {
        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->get('/scout/search');

        $response->assertStatus(403);
    }

    public function test_scouts_can_access_player_search(): void
    {
        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)->get('/scout/search');

        $response->assertStatus(200);
        $response->assertSee('Talent Discovery & Search');
        $response->assertSee('Player Name or Keyword');
        $response->assertSee('All Positions');
    }

    public function test_scout_can_filter_players_by_position(): void
    {
        $scout = User::factory()->scout()->create();

        $forwardUser = User::factory()->player()->create(['name' => 'Amine Striker']);
        PlayerProfile::factory()->create([
            'user_id' => $forwardUser->id,
            'position' => 'Forward',
        ]);

        $defenderUser = User::factory()->player()->create(['name' => 'Bilal Defender']);
        PlayerProfile::factory()->create([
            'user_id' => $defenderUser->id,
            'position' => 'Defender',
        ]);

        $response = $this->actingAs($scout)->get('/scout/search?position=Forward');

        $response->assertStatus(200);
        $response->assertSee('Amine Striker');
        $response->assertDontSee('Bilal Defender');
    }

    public function test_scout_can_filter_players_by_location(): void
    {
        $scout = User::factory()->scout()->create();

        $casaUser = User::factory()->player()->create(['name' => 'Casa Talent']);
        PlayerProfile::factory()->create([
            'user_id' => $casaUser->id,
            'location' => 'Casablanca',
        ]);

        $rabatUser = User::factory()->player()->create(['name' => 'Rabat Talent']);
        PlayerProfile::factory()->create([
            'user_id' => $rabatUser->id,
            'location' => 'Rabat',
        ]);

        $response = $this->actingAs($scout)->get('/scout/search?location=Casablanca');

        $response->assertStatus(200);
        $response->assertSee('Casa Talent');
        $response->assertDontSee('Rabat Talent');
    }

    public function test_scout_can_filter_players_by_keyword_or_name(): void
    {
        $scout = User::factory()->scout()->create();

        $targetUser = User::factory()->player()->create(['name' => 'Hamza Regragui']);
        PlayerProfile::factory()->create([
            'user_id' => $targetUser->id,
            'current_club' => 'FUS Academy',
        ]);

        $otherUser = User::factory()->player()->create(['name' => 'Youssef En-Nesyri']);
        PlayerProfile::factory()->create([
            'user_id' => $otherUser->id,
            'current_club' => 'Sevilla Youth',
        ]);

        $response = $this->actingAs($scout)->get('/scout/search?keyword=Regragui');

        $response->assertStatus(200);
        $response->assertSee('Hamza Regragui');
        $response->assertDontSee('Youssef En-Nesyri');
    }

    public function test_scout_can_filter_players_by_age_range(): void
    {
        $scout = User::factory()->scout()->create();

        // 18 years old player
        $youngUser = User::factory()->player()->create(['name' => 'Young Wonderkid']);
        PlayerProfile::factory()->create([
            'user_id' => $youngUser->id,
            'date_of_birth' => now()->subYears(18)->format('Y-m-d'),
        ]);

        // 27 years old player
        $veteranUser = User::factory()->player()->create(['name' => 'Senior Veteran']);
        PlayerProfile::factory()->create([
            'user_id' => $veteranUser->id,
            'date_of_birth' => now()->subYears(27)->format('Y-m-d'),
        ]);

        $response = $this->actingAs($scout)->get('/scout/search?min_age=17&max_age=20');

        $response->assertStatus(200);
        $response->assertSee('Young Wonderkid');
        $response->assertDontSee('Senior Veteran');
    }

    public function test_scout_can_filter_players_by_preferred_foot(): void
    {
        $scout = User::factory()->scout()->create();

        $leftUser = User::factory()->player()->create(['name' => 'Leftie Player']);
        PlayerProfile::factory()->create([
            'user_id' => $leftUser->id,
            'preferred_foot' => 'Left',
        ]);

        $rightUser = User::factory()->player()->create(['name' => 'Rightie Player']);
        PlayerProfile::factory()->create([
            'user_id' => $rightUser->id,
            'preferred_foot' => 'Right',
        ]);

        $response = $this->actingAs($scout)->get('/scout/search?preferred_foot=Left');

        $response->assertStatus(200);
        $response->assertSee('Leftie Player');
        $response->assertDontSee('Rightie Player');
    }

    public function test_search_displays_empty_state_when_no_results(): void
    {
        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)->get('/scout/search?keyword=NonExistentPlayerXYZ');

        $response->assertStatus(200);
        $response->assertSee('No players found');
    }
}
