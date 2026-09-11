<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\PlayerProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlayerProfile extends Model
{
    /** @use HasFactory<PlayerProfileFactory> */
    use HasFactory;

    public const POSITIONS = [
        'Goalkeeper',
        'Defender',
        'Midfielder',
        'Forward',
    ];

    public const PREFERRED_FEET = [
        'Right',
        'Left',
        'Both',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'position',
        'date_of_birth',
        'location',
        'preferred_foot',
        'height',
        'weight',
        'current_club',
        'football_experience',
        'bio',
        'phone',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'height' => 'integer',
            'weight' => 'integer',
        ];
    }

    /**
     * Get the user that owns the player profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the scouting interests expressed in this player profile.
     */
    public function scoutingInterests(): HasMany
    {
        return $this->hasMany(ScoutingInterest::class, 'player_profile_id');
    }

    /**
     * Get the favorites bookmarking this player profile.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'player_profile_id');
    }

    /**
     * Get the scouts that favorited this player profile.
     */
    public function favoritedByScouts(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'player_profile_id', 'scout_id')
            ->withTimestamps();
    }

    /**
     * Determine whether this player profile is favorited by the given user/scout.
     */
    public function isFavoritedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        if ($this->relationLoaded('favorites')) {
            return $this->favorites->contains('scout_id', $user->id);
        }

        return $this->favorites()->where('scout_id', $user->id)->exists();
    }

    /**
     * Get the player's age derived from date of birth.
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null;
    }
}

