<?php

namespace App\Policies;

use App\Models\Activist;
use App\Models\Group;
use App\Models\User;

class ActivistPolicy
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
    public function view(User $user, Activist $activist): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Activist $activist): bool
    {
        if ($user->is_admin) {
            return true;
        }

        $userGroup = Group::whereEmail($user->email)->first();

        if (! $userGroup) {
            return ! $activist->groups()->exists();
        }

        return ! $activist->groups()->exists() ||
            $activist->groups()->whereGroupId($userGroup->id)->exists() ||
            $activist->groups()->wherePartOfGroupId($userGroup->id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Activist $activist): bool
    {
        return $this->update($user, $activist);
    }
}
