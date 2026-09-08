<?php

namespace Tests\Feature;

use App\Models\PlayerProfile;
use App\Models\ScoutProfile;
use App\Models\ScoutingInterest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect('/login');
    }

    public function test_player_without_profile_sees_prompt_to_create_football_profile(): void
    {
        $player = User::factory()->player()->create(['name' => 'Amine Harit']);

        $response = $this->actingAs($player)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Player Dashboard');
        $response->assertSee('Welcome back, Amine Harit!');
        $response->assertSee('Complete Your Football Profile');
        $response->assertSee(route('player.profile.create'));
    }

    public function test_player_with_profile_sees_their_profile_and_scouting_activity(): void
    {
        $player = User::factory()->player()->create(['name' => 'Nayef Aguerd']);
        $playerProfile = PlayerProfile::factory()->create([
            'user_id' => $player->id,
            'position' => 'Center Back',
            'location' => 'Kenitra',
            'current_club' => 'Real Sociedad',
        ]);

        $scout = User::factory()->scout()->create(['name' => 'Piero Ausilio']);
        ScoutProfile::factory()->create([
            'user_id' => $scout->id,
            'organization' => 'Inter Milan',
        ]);

        ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
            'status' => ScoutingInterest::STATUS_PENDING,
        ]);

        $response = $this->actingAs($player)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Player Dashboard');
        $response->assertSee('Nayef Aguerd');
        $response->assertSee('Center Back');
        $response->assertSee('Kenitra');
        $response->assertSee('Real Sociedad');
        $response->assertSee('Piero Ausilio');
        $response->assertSee('Inter Milan');
        $response->assertSee('Total Scouting Interests');
    }

    public function test_scout_without_profile_sees_prompt_to_create_scout_profile(): void
    {
        $scout = User::factory()->scout()->create(['name' => 'Mehdi Benatia']);

        $response = $this->actingAs($scout)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Scout Dashboard');
        $response->assertSee('Welcome back, Mehdi Benatia!');
        $response->assertSee('Complete Your Scout Profile');
        $response->assertSee(route('scout.profile.create'));
    }

    public function test_scout_with_profile_sees_scouting_information_and_activities(): void
    {
        $scout = User::factory()->scout()->create(['name' => 'Luis Campos']);
        $scoutProfile = ScoutProfile::factory()->create([
            'user_id' => $scout->id,
            'organization' => 'Paris Saint-Germain',
            'role_title' => 'Director of Football',
            'location' => 'Paris',
        ]);

        $player = User::factory()->player()->create(['name' => 'Eliesse Ben Seghir']);
        $playerProfile = PlayerProfile::factory()->create([
            'user_id' => $player->id,
            'position' => 'Left Winger',
            'location' => 'Monaco',
        ]);

        ScoutingInterest::factory()->create([
            'scout_id' => $scout->id,
            'player_profile_id' => $playerProfile->id,
            'status' => ScoutingInterest::STATUS_CONTACTED,
        ]);

        $response = $this->actingAs($scout)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Scout Dashboard');
        $response->assertSee('Paris Saint-Germain');
        $response->assertSee('Director of Football');
        $response->assertSee('Talents Tracked');
        $response->assertSee('Eliesse Ben Seghir');
        $response->assertSee('Search Players');
    }

    public function test_admin_sees_overview_and_admin_access_controls(): void
    {
        $admin = User::factory()->admin()->create(['name' => 'Fouzi Lekjaa']);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Administrator Overview');
        $response->assertSee('Administrator Control Center');
        $response->assertSee('Total Registered Users');
        $response->assertSee(route('admin.dashboard'));
        $response->assertSee(route('admin.users.index'));
    }

    public function test_player_does_not_see_admin_controls_on_dashboard(): void
    {
        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertDontSee('Administrator Control Center');
        $response->assertDontSee('Total Registered Users');
    }

    public function test_scout_does_not_see_admin_controls_on_dashboard(): void
    {
        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertDontSee('Administrator Control Center');
        $response->assertDontSee('Total Registered Users');
    }
}
