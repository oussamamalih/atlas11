<?php

namespace Tests\Feature;

use App\Models\ScoutProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScoutProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/scout/profile/create');
        $response->assertRedirect('/login');

        $responsePost = $this->post('/scout/profile', []);
        $responsePost->assertRedirect('/login');
    }

    public function test_scout_can_view_create_profile_page(): void
    {
        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)->get('/scout/profile/create');

        $response->assertStatus(200);
        $response->assertSee('Create Scout Profile');
        $response->assertSee('Club / Academy / Organization *');
        $response->assertSee('Location / Base City *');
    }

    public function test_player_cannot_view_create_scout_profile_page(): void
    {
        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->get('/scout/profile/create');

        $response->assertStatus(403);
    }

    public function test_scout_can_create_profile(): void
    {
        $scout = User::factory()->scout()->create();

        $profileData = [
            'organization' => 'Raja Club Athletic',
            'role_title' => 'Youth Talent Recruiter',
            'location' => 'Casablanca',
            'experience_years' => 6,
            'phone' => '+212611223344',
            'license_number' => 'FRMF-9901',
            'bio' => 'Focusing on emerging talent in regional leagues across Morocco.',
        ];

        $response = $this->actingAs($scout)->post('/scout/profile', $profileData);

        $this->assertDatabaseHas('scout_profiles', [
            'user_id' => $scout->id,
            'organization' => 'Raja Club Athletic',
            'role_title' => 'Youth Talent Recruiter',
            'location' => 'Casablanca',
            'license_number' => 'FRMF-9901',
        ]);

        $profile = $scout->fresh()->scoutProfile;
        $this->assertNotNull($profile);

        $response->assertRedirect(route('scout.profile.show', $profile));
    }

    public function test_scout_profile_creation_validates_required_fields(): void
    {
        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)->post('/scout/profile', [
            'organization' => '',
            'location' => '',
        ]);

        $response->assertSessionHasErrors(['organization', 'location']);
        $this->assertDatabaseCount('scout_profiles', 0);
    }

    public function test_scout_with_existing_profile_is_redirected_away_from_create(): void
    {
        $scout = User::factory()->scout()->create();
        ScoutProfile::factory()->create(['user_id' => $scout->id]);

        $response = $this->actingAs($scout)->get('/scout/profile/create');

        $response->assertRedirect(route('scout.profile.edit'));
    }

    public function test_scout_can_view_edit_profile_page(): void
    {
        $scout = User::factory()->scout()->create();
        $profile = ScoutProfile::factory()->create([
            'user_id' => $scout->id,
            'organization' => 'FUS Rabat Academy',
            'location' => 'Rabat',
        ]);

        $response = $this->actingAs($scout)->get('/scout/profile/edit');

        $response->assertStatus(200);
        $response->assertSee('Edit Scout Profile');
        $response->assertSee('FUS Rabat Academy');
        $response->assertSee('Rabat');
    }

    public function test_scout_can_update_their_profile(): void
    {
        $scout = User::factory()->scout()->create();
        $profile = ScoutProfile::factory()->create([
            'user_id' => $scout->id,
            'organization' => 'Wydad AC Youth',
            'location' => 'Casablanca',
        ]);

        $updateData = [
            'organization' => 'Moroccan FA (FRMF)',
            'role_title' => 'National Youth Scout',
            'location' => 'Rabat',
            'experience_years' => 12,
            'phone' => '+212677889900',
            'license_number' => 'FRMF-PRO-01',
            'bio' => 'Promoted to national recruitment board.',
        ];

        $response = $this->actingAs($scout)->put('/scout/profile', $updateData);

        $response->assertRedirect(route('scout.profile.show', $profile));

        $this->assertDatabaseHas('scout_profiles', [
            'id' => $profile->id,
            'user_id' => $scout->id,
            'organization' => 'Moroccan FA (FRMF)',
            'role_title' => 'National Youth Scout',
            'location' => 'Rabat',
            'experience_years' => 12,
        ]);
    }

    public function test_player_cannot_update_scout_profile(): void
    {
        $scout = User::factory()->scout()->create();
        ScoutProfile::factory()->create(['user_id' => $scout->id]);

        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->put('/scout/profile', [
            'organization' => 'Hacker Agency',
            'location' => 'Unknown',
        ]);

        $response->assertStatus(403);
    }

    public function test_authenticated_users_can_view_a_scout_profile(): void
    {
        $scout = User::factory()->scout()->create(['name' => 'Tarik Recruiter']);
        $profile = ScoutProfile::factory()->create([
            'user_id' => $scout->id,
            'organization' => 'RS Berkane Scouts',
            'location' => 'Berkane',
        ]);

        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->get(route('scout.profile.show', $profile));

        $response->assertStatus(200);
        $response->assertSee('Tarik Recruiter');
        $response->assertSee('RS Berkane Scouts');
        $response->assertSee('Berkane');
    }

    public function test_scout_profile_index_route_redirects_appropriately(): void
    {
        // Scout without profile goes to create
        $scoutWithoutProfile = User::factory()->scout()->create();
        $response = $this->actingAs($scoutWithoutProfile)->get(route('scout.profile.index'));
        $response->assertRedirect(route('scout.profile.create'));

        // Scout with profile goes to show
        $scoutWithProfile = User::factory()->scout()->create();
        $profile = ScoutProfile::factory()->create(['user_id' => $scoutWithProfile->id]);
        $response = $this->actingAs($scoutWithProfile)->get(route('scout.profile.index'));
        $response->assertRedirect(route('scout.profile.show', $profile));
    }

    public function test_guest_cannot_view_scout_profile(): void
    {
        $scout = User::factory()->scout()->create();
        $profile = ScoutProfile::factory()->create(['user_id' => $scout->id]);

        $response = $this->get(route('scout.profile.show', $profile));

        $response->assertRedirect('/login');
    }

    public function test_player_cannot_view_edit_scout_profile_page(): void
    {
        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->get(route('scout.profile.edit'));

        $response->assertStatus(403);
    }

    public function test_admin_cannot_update_scout_profile_directly(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->put('/scout/profile', [
            'organization' => 'Admin Org',
            'location' => 'Rabat',
        ]);

        $response->assertStatus(403);
    }

    public function test_scout_without_profile_accessing_edit_is_redirected_to_create(): void
    {
        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)->get(route('scout.profile.edit'));

        $response->assertRedirect(route('scout.profile.create'));
    }

    public function test_scout_profile_update_validates_required_fields(): void
    {
        $scout = User::factory()->scout()->create();
        ScoutProfile::factory()->create(['user_id' => $scout->id]);

        $response = $this->actingAs($scout)->put('/scout/profile', [
            'organization' => '',
            'location' => '',
        ]);

        $response->assertSessionHasErrors(['organization', 'location']);
    }
}
