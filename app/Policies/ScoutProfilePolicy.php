<?php

namespace App\Policies;

use App\Models\ScoutProfile;
use App\Models\User;

class ScoutProfilePolicy
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
    public function view(User $user, ScoutProfile $scoutProfile): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isScout() && ! $user->scoutProfile()->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ScoutProfile $scoutProfile): bool
    {
        return $user->isScout() && $user->id === $scoutProfile->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ScoutProfile $scoutProfile): bool
    {
        return $user->id === $scoutProfile->user_id || $user->isAdmin();
    }
}
