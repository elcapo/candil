<?php

use App\Filament\Resources\ActivistResource\Pages\CreateActivist;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('has a create activist form', function () {
    actingAs(User::factory()->create());

    livewire(CreateActivist::class)
        ->assertFormExists();
});
