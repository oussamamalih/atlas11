<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Account Type');
        $response->assertSee('player');
        $response->assertSee('scout');
    }

    public function test_new_users_can_register_as_player(): void
    {
        $response = $this->post('/register', [
            'name' => 'Player User',
            'email' => 'player@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => User::ROLE_PLAYER,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'player@example.com',
            'role' => User::ROLE_PLAYER,
        ]);
    }

    public function test_new_users_can_register_as_scout(): void
    {
        $response = $this->post('/register', [
            'name' => 'Scout User',
            'email' => 'scout@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => User::ROLE_SCOUT,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'scout@example.com',
            'role' => User::ROLE_SCOUT,
        ]);
    }

    public function test_role_is_required_for_registration(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertGuest();
    }

    public function test_users_cannot_register_with_admin_or_invalid_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => User::ROLE_ADMIN,
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertGuest();

        $responseInvalid = $this->post('/register', [
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'superuser',
        ]);

        $responseInvalid->assertSessionHasErrors('role');
        $this->assertGuest();
    }
}
