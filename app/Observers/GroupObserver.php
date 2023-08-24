<?php

namespace App\Observers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GroupObserver
{
    /**
     * Handle the Group "created" event.
     */
    public function created(Group $group): void
    {
        User::create([
            'name' => $group->name,
            'email' => $group->email,
            'password' => Hash::make(self::password()),
        ]);
    }

    /**
     * Handle the Group "updated" event.
     */
    public function updated(Group $group): void
    {
        if ($group->email === $group->getOriginal('email')) {
            return;
        }

        User::whereEmail($group->getOriginal('email'))->delete();

        User::create([
            'name' => $group->name,
            'email' => $group->email,
            'password' => Hash::make(self::password()),
        ]);
    }

    /**
     * Handle the Group "deleted" event.
     */
    public function deleted(Group $group): void
    {
        User::whereEmail($group->email)->delete();
    }

    /**
     * Get a new randomly generated password.
     */
    private static function password(): string
    {
        return app()->isLocal() ? 'password' : Str::password(8, symbols: false);
    }
}
