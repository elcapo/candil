<?php

use App\Filament\Resources\GroupResource\Pages\CreateGroup;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('has a create group form', function () {
    actingAs(User::factory()->create());

    livewire(CreateGroup::class)
        ->assertFormExists();
});
