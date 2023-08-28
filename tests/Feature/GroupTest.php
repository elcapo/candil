<?php

use App\Filament\Resources\GroupResource\Pages\CreateGroup;

use function Pest\Livewire\livewire;

it('has a create group form', function () {
    livewire(CreateGroup::class)
        ->assertFormExists();
});
