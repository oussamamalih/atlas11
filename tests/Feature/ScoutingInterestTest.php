<?php

namespace Tests\Feature;

use App\Models\PlayerProfile;
use App\Models\ScoutProfile;
use App\Models\ScoutingInterest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScoutingInterestTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_express_interest_in_players(): void
    {
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $response = $this->post(route('scouting.interests.store', $playerProfile), [
            'message' => 'Trial invitation',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_players_cannot_express_interest_in_players(): void
    {
        $playerA = User::factory()->player()->create();
        $playerB = User::factory()->player()->create();
        $playerProfileB = PlayerProfile::factory()->create(['user_id' => $playerB->id]);

        $response = $this->actingAs($playerA)->post(route('scouting.interests.store', $playerProfileB), [
            'message' => 'Hey',
        ]);

        $response->assertStatus(403);
    }

    public function test_scout_can_express_interest_in_a_player(): void
    {
        $scout = User::factory()->scout()->create();
        ScoutProfile::factory()->create(['user_id' => $scout->id]);

        $player = User::factory()->player()->create(['name' => 'Soufiane Rahimi']);
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $response = $this->actingAs($scout)->post(route('scouting.interests.store', $playerProfile), [
            'message' => 'We would love to invite you for a trial at our academy next week.',
        ]);

        $response->assertSessionHas('status');

        $this->assertDatabaseHas('scouting_interests', [
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
            'status' => ScoutingInterest::STATUS_PENDING,
            'message' => 'We would love to invite you for a trial at our academy next week.',
        ]);
    }

    public function test_duplicate_scouting_interest_is_prevented(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        // First interest
        ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
        ]);

        // Second attempt
        $response = $this->actingAs($scout)->post(route('scouting.interests.store', $playerProfile), [
            'message' => 'Duplicate attempt',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseCount('scouting_interests', 1);
    }

    public function test_scout_can_view_sent_scouting_interests(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create(['name' => 'Achraf Hakimi']);
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
        ]);

        $response = $this->actingAs($scout)->get(route('scouting.interests.index'));

        $response->assertStatus(200);
        $response->assertSee('Achraf Hakimi');
        $response->assertSee('My Sent Scouting Interests');
    }

    public function test_player_can_view_received_scouting_interests(): void
    {
        $scout = User::factory()->scout()->create(['name' => 'Monchi Scout']);
        ScoutProfile::factory()->create([
            'user_id' => $scout->id,
            'organization' => 'Sevilla FC Academy',
        ]);

        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
        ]);

        $response = $this->actingAs($player)->get(route('scouting.interests.index'));

        $response->assertStatus(200);
        $response->assertSee('Monchi Scout');
        $response->assertSee('Sevilla FC Academy');
        $response->assertSee('Scouting Interests Received');
    }

    public function test_unrelated_user_cannot_view_scouting_interest_details(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $interest = ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
        ]);

        $otherUser = User::factory()->player()->create();

        $response = $this->actingAs($otherUser)->get(route('scouting.interests.show', $interest));

        $response->assertStatus(403);
    }

    public function test_player_viewing_interest_updates_status_to_viewed(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $interest = ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
            'status' => ScoutingInterest::STATUS_PENDING,
        ]);

        $response = $this->actingAs($player)->get(route('scouting.interests.show', $interest));

        $response->assertStatus(200);

        $this->assertDatabaseHas('scouting_interests', [
            'id' => $interest->id,
            'status' => ScoutingInterest::STATUS_VIEWED,
        ]);
    }

    public function test_authorized_user_can_update_scouting_interest_status(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $interest = ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
            'status' => ScoutingInterest::STATUS_VIEWED,
        ]);

        $response = $this->actingAs($scout)->patch(route('scouting.interests.update', $interest), [
            'status' => ScoutingInterest::STATUS_CONTACTED,
        ]);

        $response->assertSessionHas('status');

        $this->assertDatabaseHas('scouting_interests', [
            'id' => $interest->id,
            'status' => ScoutingInterest::STATUS_CONTACTED,
        ]);
    }

    public function test_player_profile_page_shows_scouting_interest_state_for_scout(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create(['name' => 'Yassine Bounou']);
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        // When interest is not yet expressed
        $response1 = $this->actingAs($scout)->get(route('player.profile.show', $playerProfile));
        $response1->assertStatus(200);
        $response1->assertSee('Express Interest');

        // Express interest
        ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
        ]);

        // When interest is already expressed
        $response2 = $this->actingAs($scout)->get(route('player.profile.show', $playerProfile));
        $response2->assertStatus(200);
        $response2->assertSee('Scouting Interest Expressed');
    }

    public function test_guest_cannot_access_scouting_interest_routes(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);
        $interest = ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
        ]);

        $this->get(route('scouting.interests.index'))->assertRedirect('/login');
        $this->get(route('scouting.interests.show', $interest))->assertRedirect('/login');
        $this->patch(route('scouting.interests.update', $interest), ['status' => 'viewed'])->assertRedirect('/login');
    }

    public function test_admin_cannot_express_interest_in_players(): void
    {
        $admin = User::factory()->admin()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);

        $response = $this->actingAs($admin)->post(route('scouting.interests.store', $playerProfile), [
            'message' => 'Admin trying to scout',
        ]);

        $response->assertStatus(403);
    }

    public function test_unrelated_user_cannot_update_scouting_interest_status(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);
        $interest = ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
            'status' => ScoutingInterest::STATUS_PENDING,
        ]);

        $unrelatedUser = User::factory()->player()->create();

        $response = $this->actingAs($unrelatedUser)->patch(route('scouting.interests.update', $interest), [
            'status' => ScoutingInterest::STATUS_CLOSED,
        ]);

        $response->assertStatus(403);
        $this->assertEquals(ScoutingInterest::STATUS_PENDING, $interest->fresh()->status);
    }

    public function test_scouting_interest_update_validates_status(): void
    {
        $scout = User::factory()->scout()->create();
        $player = User::factory()->player()->create();
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);
        $interest = ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
            'status' => ScoutingInterest::STATUS_PENDING,
        ]);

        $response = $this->actingAs($scout)->patch(route('scouting.interests.update', $interest), [
            'status' => 'invalid-status',
        ]);

        $response->assertSessionHasErrors('status');
    }

    public function test_admin_can_view_and_update_scouting_interest(): void
    {
        $admin = User::factory()->admin()->create();
        $scout = User::factory()->scout()->create(['name' => 'Scout Leader']);
        $player = User::factory()->player()->create(['name' => 'Future Star']);
        $playerProfile = PlayerProfile::factory()->create(['user_id' => $player->id]);
        $interest = ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
            'status' => ScoutingInterest::STATUS_PENDING,
        ]);

        // Admin can view
        $responseView = $this->actingAs($admin)->get(route('scouting.interests.show', $interest));
        $responseView->assertStatus(200);
        $responseView->assertSee('Scout Leader');
        $responseView->assertSee('Future Star');

        // Admin can update status
        $responseUpdate = $this->actingAs($admin)->patch(route('scouting.interests.update', $interest), [
            'status' => ScoutingInterest::STATUS_CLOSED,
        ]);
        $responseUpdate->assertSessionHas('status');
        $this->assertEquals(ScoutingInterest::STATUS_CLOSED, $interest->fresh()->status);
    }
}
