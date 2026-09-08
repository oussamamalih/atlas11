<?php

namespace Tests\Feature;

use App\Models\PlayerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/player/profile/create');
        $response->assertRedirect('/login');

        $responsePost = $this->post('/player/profile', []);
        $responsePost->assertRedirect('/login');
    }

    public function test_player_can_view_create_profile_page(): void
    {
        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->get('/player/profile/create');

        $response->assertStatus(200);
        $response->assertSee('Create Football Profile');
        $response->assertSee('Position *');
        $response->assertSee('City / Region *');
    }

    public function test_scout_cannot_view_create_player_profile_page(): void
    {
        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)->get('/player/profile/create');

        $response->assertStatus(403);
    }

    public function test_player_can_create_football_profile(): void
    {
        $player = User::factory()->player()->create();

        $profileData = [
            'position' => 'Midfielder',
            'date_of_birth' => '2004-05-15',
            'location' => 'Casablanca',
            'preferred_foot' => 'Right',
            'height' => 178,
            'weight' => 72,
            'current_club' => 'Raja CA Youth',
            'football_experience' => 'Played 3 seasons in regional youth league.',
            'bio' => 'Agile box-to-box midfielder with high stamina and vision.',
            'phone' => '+212612345678',
        ];

        $response = $this->actingAs($player)->post('/player/profile', $profileData);

        $this->assertDatabaseHas('player_profiles', [
            'user_id' => $player->id,
            'position' => 'Midfielder',
            'location' => 'Casablanca',
            'current_club' => 'Raja CA Youth',
        ]);

        $profile = $player->fresh()->playerProfile;
        $this->assertNotNull($profile);

        $response->assertRedirect(route('player.profile.show', $profile));
    }

    public function test_player_profile_creation_validates_required_fields(): void
    {
        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->post('/player/profile', [
            'position' => '',
            'date_of_birth' => '',
            'location' => '',
        ]);

        $response->assertSessionHasErrors(['position', 'date_of_birth', 'location']);
        $this->assertDatabaseCount('player_profiles', 0);
    }

    public function test_player_with_existing_profile_is_redirected_away_from_create(): void
    {
        $player = User::factory()->player()->create();
        PlayerProfile::factory()->create(['user_id' => $player->id]);

        $response = $this->actingAs($player)->get('/player/profile/create');

        $response->assertRedirect(route('player.profile.edit'));
    }

    public function test_player_can_view_edit_profile_page(): void
    {
        $player = User::factory()->player()->create();
        $profile = PlayerProfile::factory()->create([
            'user_id' => $player->id,
            'location' => 'Marrakech',
            'position' => 'Forward',
        ]);

        $response = $this->actingAs($player)->get('/player/profile/edit');

        $response->assertStatus(200);
        $response->assertSee('Edit Football Profile');
        $response->assertSee('Marrakech');
        $response->assertSee('Forward');
    }

    public function test_player_can_update_their_football_profile(): void
    {
        $player = User::factory()->player()->create();
        $profile = PlayerProfile::factory()->create([
            'user_id' => $player->id,
            'position' => 'Defender',
            'location' => 'Rabat',
            'date_of_birth' => '2003-08-20',
        ]);

        $updateData = [
            'position' => 'Midfielder',
            'date_of_birth' => '2003-08-20',
            'location' => 'Tangier',
            'preferred_foot' => 'Left',
            'height' => 183,
            'weight' => 76,
            'current_club' => 'Ittihad Tanger Academy',
            'football_experience' => 'Promoted to U21 squad.',
            'bio' => 'Strong left-footed midfielder.',
            'phone' => '+212699887766',
        ];

        $response = $this->actingAs($player)->put('/player/profile', $updateData);

        $response->assertRedirect(route('player.profile.show', $profile));

        $this->assertDatabaseHas('player_profiles', [
            'id' => $profile->id,
            'user_id' => $player->id,
            'position' => 'Midfielder',
            'location' => 'Tangier',
            'preferred_foot' => 'Left',
            'current_club' => 'Ittihad Tanger Academy',
        ]);
    }

    public function test_scout_cannot_update_player_profile(): void
    {
        $player = User::factory()->player()->create();
        PlayerProfile::factory()->create(['user_id' => $player->id]);

        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)->put('/player/profile', [
            'position' => 'Forward',
            'date_of_birth' => '2002-01-01',
            'location' => 'Agadir',
        ]);

        $response->assertStatus(403);
    }

    public function test_authenticated_users_can_view_a_player_profile(): void
    {
        $player = User::factory()->player()->create(['name' => 'Achraf Talent']);
        $profile = PlayerProfile::factory()->create([
            'user_id' => $player->id,
            'position' => 'Forward',
            'location' => 'Casablanca',
        ]);

        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)->get(route('player.profile.show', $profile));

        $response->assertStatus(200);
        $response->assertSee('Achraf Talent');
        $response->assertSee('Forward');
        $response->assertSee('Casablanca');
    }

    public function test_player_profile_index_route_redirects_appropriately(): void
    {
        // Player without profile goes to create
        $playerWithoutProfile = User::factory()->player()->create();
        $response = $this->actingAs($playerWithoutProfile)->get(route('player.profile.index'));
        $response->assertRedirect(route('player.profile.create'));

        // Player with profile goes to show
        $playerWithProfile = User::factory()->player()->create();
        $profile = PlayerProfile::factory()->create(['user_id' => $playerWithProfile->id]);
        $response = $this->actingAs($playerWithProfile)->get(route('player.profile.index'));
        $response->assertRedirect(route('player.profile.show', $profile));
    }
}
