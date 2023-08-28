<?php

use App\Filament\Resources\ActivistResource\Pages\CreateActivist;

use function Pest\Livewire\livewire;

it('has a create activist form', function () {
    livewire(CreateActivist::class)
        ->assertFormExists();
});
