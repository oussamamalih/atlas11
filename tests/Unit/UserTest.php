<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_user_role_helper_methods(): void
    {
        $player = new User(['role' => User::ROLE_PLAYER]);
        $this->assertTrue($player->isPlayer());
        $this->assertFalse($player->isScout());
        $this->assertFalse($player->isAdmin());

        $scout = new User(['role' => User::ROLE_SCOUT]);
        $this->assertFalse($scout->isPlayer());
        $this->assertTrue($scout->isScout());
        $this->assertFalse($scout->isAdmin());

        $admin = new User(['role' => User::ROLE_ADMIN]);
        $this->assertFalse($admin->isPlayer());
        $this->assertFalse($admin->isScout());
        $this->assertTrue($admin->isAdmin());
    }

    public function test_user_role_constants(): void
    {
        $this->assertSame('player', User::ROLE_PLAYER);
        $this->assertSame('scout', User::ROLE_SCOUT);
        $this->assertSame('admin', User::ROLE_ADMIN);
    }
}
