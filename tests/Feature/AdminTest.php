<?php

namespace Tests\Feature;

use App\Models\PlayerProfile;
use App\Models\ScoutProfile;
use App\Models\ScoutingInterest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect('/login');
    }

    public function test_guests_are_redirected_from_admin_users_index(): void
    {
        $response = $this->get(route('admin.users.index'));

        $response->assertRedirect('/login');
    }

    public function test_guests_cannot_update_users(): void
    {
        $user = User::factory()->player()->create();

        $response = $this->put(route('admin.users.update', $user), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'role' => User::ROLE_SCOUT,
        ]);

        $response->assertRedirect('/login');
    }

    public function test_guests_cannot_delete_users(): void
    {
        $user = User::factory()->player()->create();

        $response = $this->delete(route('admin.users.destroy', $user));

        $response->assertRedirect('/login');
    }

    public function test_players_cannot_access_admin_dashboard(): void
    {
        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_players_cannot_access_admin_users(): void
    {
        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_players_cannot_update_users(): void
    {
        $player = User::factory()->player()->create();
        $targetUser = User::factory()->player()->create();

        $response = $this->actingAs($player)->put(route('admin.users.update', $targetUser), [
            'name' => 'Hacked Name',
            'email' => 'hacked@example.com',
            'role' => User::ROLE_ADMIN,
        ]);

        $response->assertStatus(403);
    }

    public function test_players_cannot_delete_users(): void
    {
        $player = User::factory()->player()->create();
        $targetUser = User::factory()->player()->create();

        $response = $this->actingAs($player)->delete(route('admin.users.destroy', $targetUser));

        $response->assertStatus(403);
    }

    public function test_scouts_cannot_access_admin_dashboard(): void
    {
        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_scouts_cannot_access_admin_users(): void
    {
        $scout = User::factory()->scout()->create();

        $response = $this->actingAs($scout)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_scouts_cannot_update_users(): void
    {
        $scout = User::factory()->scout()->create();
        $targetUser = User::factory()->player()->create();

        $response = $this->actingAs($scout)->put(route('admin.users.update', $targetUser), [
            'name' => 'Hacked Name',
            'email' => 'hacked@example.com',
            'role' => User::ROLE_ADMIN,
        ]);

        $response->assertStatus(403);
    }

    public function test_scouts_cannot_delete_users(): void
    {
        $scout = User::factory()->scout()->create();
        $targetUser = User::factory()->player()->create();

        $response = $this->actingAs($scout)->delete(route('admin.users.destroy', $targetUser));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertSee('Admin Dashboard');
        $response->assertSee('Total Users');
        $response->assertSee('Players');
        $response->assertSee('Scouts');
    }

    public function test_admin_can_view_users_list(): void
    {
        $admin = User::factory()->admin()->create();
        $player = User::factory()->player()->create(['name' => 'Achraf Hakimi']);
        $scout = User::factory()->scout()->create(['name' => 'Monchi']);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertSee('Achraf Hakimi');
        $response->assertSee('Monchi');
    }

    public function test_admin_can_filter_users_by_role(): void
    {
        $admin = User::factory()->admin()->create();
        $player = User::factory()->player()->create(['name' => 'Yassine Bounou']);
        $scout = User::factory()->scout()->create(['name' => 'Walid Regragui']);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['role' => User::ROLE_PLAYER]));

        $response->assertStatus(200);
        $response->assertSee('Yassine Bounou');
        $response->assertDontSee('Walid Regragui');
    }

    public function test_admin_can_search_users_by_name_or_email(): void
    {
        $admin = User::factory()->admin()->create();
        $player1 = User::factory()->player()->create(['name' => 'Azzedine Ounahi', 'email' => 'azzedine@example.com']);
        $player2 = User::factory()->player()->create(['name' => 'Sofyan Amrabat', 'email' => 'sofyan@example.com']);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['search' => 'Azzedine']));

        $response->assertStatus(200);
        $response->assertSee('Azzedine Ounahi');
        $response->assertDontSee('Sofyan Amrabat');
    }

    public function test_admin_can_view_user_details(): void
    {
        $admin = User::factory()->admin()->create();
        $player = User::factory()->player()->create(['name' => 'Brahim Diaz', 'email' => 'brahim@example.com']);
        PlayerProfile::factory()->create([
            'user_id' => $player->id,
            'position' => 'Attacking Midfielder',
            'location' => 'Madrid / Casablanca',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.show', $player));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.show');
        $response->assertSee('Brahim Diaz');
        $response->assertSee('brahim@example.com');
        $response->assertSee('Attacking Midfielder');
        $response->assertSee('Madrid / Casablanca');
    }

    public function test_admin_can_view_edit_user_page(): void
    {
        $admin = User::factory()->admin()->create();
        $player = User::factory()->player()->create(['name' => 'Ayoub El Kaabi']);

        $response = $this->actingAs($admin)->get(route('admin.users.edit', $player));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');
        $response->assertSee('Ayoub El Kaabi');
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->admin()->create();
        $player = User::factory()->player()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'role' => User::ROLE_PLAYER,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $player), [
            'name' => 'New Scout Name',
            'email' => 'newscout@example.com',
            'role' => User::ROLE_SCOUT,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('users', [
            'id' => $player->id,
            'name' => 'New Scout Name',
            'email' => 'newscout@example.com',
            'role' => User::ROLE_SCOUT,
        ]);
    }

    public function test_admin_cannot_demote_themselves(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@atlas11.ma',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $admin), [
            'name' => 'Admin User',
            'email' => 'admin@atlas11.ma',
            'role' => User::ROLE_PLAYER,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'You cannot remove your own administrator role.');

        $this->assertEquals(User::ROLE_ADMIN, $admin->fresh()->role);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->admin()->create();
        $player = User::factory()->player()->create(['name' => 'To Delete']);
        PlayerProfile::factory()->create(['user_id' => $player->id]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $player));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseMissing('users', [
            'id' => $player->id,
        ]);
        $this->assertDatabaseMissing('player_profiles', [
            'user_id' => $player->id,
        ]);
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'You cannot delete your own account from the administrator panel.');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
        ]);
    }

    public function test_admin_navigation_links_are_visible_for_admin_users(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
        $response->assertSee('Manage Users');
    }

    public function test_admin_navigation_links_are_not_visible_for_players(): void
    {
        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertDontSee('Admin Dashboard');
        $response->assertDontSee('Manage Users');
    }
}
