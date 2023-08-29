<?php

namespace App\Policies;

use App\Models\ActivistGroup;
use App\Models\Group;
use App\Models\User;

class ActivistGroupPolicy
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
    public function view(User $user, ActivistGroup $activistGroup): bool
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
    public function update(User $user, ActivistGroup $activistGroup): bool
    {
        if ($user->is_admin) {
            return true;
        }

        $userGroup = Group::whereEmail($user->email)->first();

        if (! $userGroup) {
            return false;
        }

        return $activistGroup->group_id === $userGroup->id ||
            $activistGroup->part_of_group_id === $userGroup->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ActivistGroup $activistGroup): bool
    {
        return $this->update($user, $activistGroup);
    }
}
