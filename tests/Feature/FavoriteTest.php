<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\PlayerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get('/favorites');
        $response->assertRedirect('/login');
    }

    public function test_players_cannot_access_favorites(): void
    {
        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->get('/favorites');

        $response->assertStatus(403);
    }

    public function test_scouts_can_access_favorites_index(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();

        $response = $this->actingAs($scout)->get('/favorites');

        $response->assertStatus(200);
        $response->assertSee('My Saved Talents');
        $response->assertSee('No saved talents yet');
    }

    public function test_scout_can_favorite_a_player(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $response = $this->actingAs($scout)
            ->post('/players/' . $playerProfile->id . '/favorite');

        $response->assertSessionHas('status');
        $this->assertTrue(Favorite::where('scout_id', $scout->id)
            ->where('player_profile_id', $playerProfile->id)
            ->exists());
    }

    public function test_scout_can_unfavorite_a_player(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        // First, favorite the player
        $scout->favorites()->create(['player_profile_id' => $playerProfile->id]);

        $response = $this->actingAs($scout)
            ->delete('/players/' . $playerProfile->id . '/favorite');

        $response->assertSessionHas('status');
        $this->assertFalse(Favorite::where('scout_id', $scout->id)
            ->where('player_profile_id', $playerProfile->id)
            ->exists());
    }

    public function test_scout_cannot_favorite_same_player_twice(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        // Favorite once
        $scout->favorites()->create(['player_profile_id' => $playerProfile->id]);

        $response = $this->actingAs($scout)
            ->post('/players/' . $playerProfile->id . '/favorite');

        $response->assertSessionHas('status');
        $this->assertCount(1, Favorite::where('scout_id', $scout->id)
            ->where('player_profile_id', $playerProfile->id)
            ->get());
    }

    public function test_player_cannot_favorite_another_player(): void
    {
        $player1 = User::factory()->player()->create(['name' => 'Player One']);
        $player2 = User::factory()->player()->create(['name' => 'Player Two']);
        $player1Profile = PlayerProfile::factory()->create(['user_id' => $player1->id]);
        $player2Profile = PlayerProfile::factory()->create(['user_id' => $player2->id]);

        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)
            ->post('/players/' . $player2Profile->id . '/favorite');

        $response->assertStatus(403);
    }

    public function test_scout_can_see_if_player_is_favorited(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        // Player is not favorited initially
        $this->assertFalse($playerProfile->isFavoritedBy($scout));

        // Favorite the player
        $scout->favorites()->create(['player_profile_id' => $playerProfile->id]);

        // Player is now favorited
        $this->assertTrue($playerProfile->isFavoritedBy($scout));
    }

    public function test_scout_cannot_access_favorite_endpoints_without_role(): void
    {
        $player = User::factory()->player()->create();

        // Try to favorite a player as a player
        $response = $this->actingAs($player)
            ->post('/players/1/favorite');

        $response->assertStatus(403);
    }
}