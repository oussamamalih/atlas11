<?php

namespace App\Models;

use Database\Factories\FavoriteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    /** @use HasFactory<FavoriteFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'scout_id',
        'player_profile_id',
    ];

    /**
     * Get the scout (User) who saved this favorite.
     */
    public function scout(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scout_id');
    }

    /**
     * Get the favorited player profile.
     */
    public function playerProfile(): BelongsTo
    {
        return $this->belongsTo(PlayerProfile::class, 'player_profile_id');
    }
}
