<?php

namespace App\Models;

use Database\Factories\ScoutingInterestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScoutingInterest extends Model
{
    /** @use HasFactory<ScoutingInterestFactory> */
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_VIEWED = 'viewed';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_CLOSED = 'closed';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'scout_id',
        'player_profile_id',
        'status',
        'message',
    ];

    /**
     * Get the scout (user) that expressed interest.
     */
    public function scout(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scout_id');
    }

    /**
     * Get the player profile that received the interest.
     */
    public function playerProfile(): BelongsTo
    {
        return $this->belongsTo(PlayerProfile::class, 'player_profile_id');
    }

    /**
     * Helper to get the player User model directly.
     */
    public function getPlayerUserAttribute(): ?User
    {
        return $this->playerProfile?->user;
    }
}
