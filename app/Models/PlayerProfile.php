<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\PlayerProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * Get the player's age derived from date of birth.
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null;
    }
}
