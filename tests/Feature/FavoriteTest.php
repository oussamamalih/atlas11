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

        $response = $this->actingAs($player1)
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
        $playerProfile = PlayerProfile::factory()->create();

        // Try to favorite a player as a player
        $response = $this->actingAs($player)
            ->post('/players/' . $playerProfile->id . '/favorite');

        $response->assertStatus(403);
    }

    public function test_scout_sees_save_button_on_search_card(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create(['name' => 'Youssef En-Nesyri']);
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $response = $this->actingAs($scout)->get(route('scout.search'));

        $response->assertOk();
        $response->assertSee('Youssef En-Nesyri');
        $response->assertSee('+ Save to Shortlist');
    }

    public function test_scout_sees_saved_state_on_search_card(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create(['name' => 'Youssef En-Nesyri']);
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $scout->favorites()->create(['player_profile_id' => $playerProfile->id]);

        $response = $this->actingAs($scout)->get(route('scout.search'));

        $response->assertOk();
        $response->assertSee('Youssef En-Nesyri');
        $response->assertSee('Saved - Remove from Shortlist');
        $response->assertDontSee('+ Save to Shortlist');
    }

    public function test_scout_sees_favorite_toggle_on_player_profile(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create(['name' => 'Youssef En-Nesyri']);
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $response = $this->actingAs($scout)->get(route('player.profile.show', $playerProfile));

        $response->assertOk();
        $response->assertSee('Shortlist This Talent');
        $response->assertSee('Add to Shortlist');
    }

    public function test_non_scout_does_not_see_favorite_toggle(): void
    {
        $player = User::factory()->player()->create(['name' => 'Youssef En-Nesyri']);
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $response = $this->actingAs($player)->get(route('player.profile.show', $playerProfile));

        $response->assertOk();
        $response->assertDontSee('Add to Shortlist');
        $response->assertDontSee('Remove from Shortlist');
    }

    public function test_search_shows_status_flash_after_favoriting(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create(['name' => 'Youssef En-Nesyri']);
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $response = $this->actingAs($scout)
            ->from(route('scout.search'))
            ->post('/players/' . $playerProfile->id . '/favorite');

        $response->assertRedirect(route('scout.search'));
        $response->assertSessionHas('status');

        $this->actingAs($scout)->get(route('scout.search'))
            ->assertSee('successfully added to your shortlisted favorites');
    }

    public function test_admin_cannot_access_favorites(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/favorites');

        $response->assertStatus(403);
    }
}