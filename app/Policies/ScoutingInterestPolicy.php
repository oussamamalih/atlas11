<?php

namespace App\Policies;

use App\Models\ScoutingInterest;
use App\Models\User;

class ScoutingInterestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isScout() || $user->isPlayer() || $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ScoutingInterest $scoutingInterest): bool
    {
        return $user->id === $scoutingInterest->scout_id
            || $user->id === $scoutingInterest->playerProfile->user_id
            || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isScout();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ScoutingInterest $scoutingInterest): bool
    {
        return $user->id === $scoutingInterest->scout_id
            || $user->id === $scoutingInterest->playerProfile->user_id
            || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ScoutingInterest $scoutingInterest): bool
    {
        return $user->id === $scoutingInterest->scout_id || $user->isAdmin();
    }
}
