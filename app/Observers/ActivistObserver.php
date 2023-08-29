<?php

namespace App\Observers;

use App\Models\Person;

class ActivistObserver
{
    /**
     * Handle the Activist "creating" event.
     */
    public function creating(Person $activist): void
    {
        $activist->full_name = self::full_name($activist);
    }

    /**
     * Handle the Activist "updating" event.
     */
    public function updating(Person $activist): void
    {
        $activist->full_name = self::full_name($activist);
    }

    private static function full_name(Person $activist): string
    {
        return implode(' ', array_filter([
            $activist->first_name,
            $activist->surname,
            $activist->second_surname,
        ]));
    }
}
