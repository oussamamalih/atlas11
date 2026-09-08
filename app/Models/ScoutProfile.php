<?php

namespace App\Models;

use Database\Factories\ScoutProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScoutProfile extends Model
{
    /** @use HasFactory<ScoutProfileFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'organization',
        'role_title',
        'location',
        'experience_years',
        'phone',
        'license_number',
        'bio',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
        ];
    }

    /**
     * Get the user that owns the scout profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
