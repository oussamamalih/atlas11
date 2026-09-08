<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_PLAYER = 'player';
    public const ROLE_SCOUT = 'scout';
    public const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isPlayer(): bool
    {
        return $this->role === self::ROLE_PLAYER;
    }

    public function isScout(): bool
    {
        return $this->role === self::ROLE_SCOUT;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Get the player profile associated with the user.
     */
    public function playerProfile(): HasOne
    {
        return $this->hasOne(PlayerProfile::class);
    }

    /**
     * Get the scout profile associated with the user.
     */
     public function scoutProfile(): HasOne
     {
         return $this->hasOne(ScoutProfile::class);
     }

    /**
     * Get the scouting interests sent by the user (as a scout).
     */
    public function sentScoutingInterests(): HasMany
    {
        return $this->hasMany(ScoutingInterest::class, 'scout_id');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}