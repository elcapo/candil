<?php

namespace App\Policies;

use App\Models\Person;
use App\Models\Group;
use App\Models\User;

class PersonPolicy
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
    public function view(User $user, Person $person): bool
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
    public function update(User $user, Person $person): bool
    {
        if ($user->is_admin) {
            return true;
        }

        $group = Group::whereEmail($user->email)->first();

        if (! $group) {
            return ! $person->groups()->exists();
        }

        return ! $person->groups()->exists() ||
            $person->groups()->whereGroupId($group->id)->exists() ||
            $person->groups()->wherePartOfGroupId($group->id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Person $person): bool
    {
        return $this->update($user, $person);
    }
}
