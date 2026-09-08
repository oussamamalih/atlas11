<?php

namespace App\Policies;

use App\Models\PlayerProfile;
use App\Models\User;

class PlayerProfilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlayerProfile $playerProfile): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isPlayer() && ! $user->playerProfile()->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PlayerProfile $playerProfile): bool
    {
        return $user->isPlayer() && $user->id === $playerProfile->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PlayerProfile $playerProfile): bool
    {
        return $user->id === $playerProfile->user_id || $user->isAdmin();
    }
}
