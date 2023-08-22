<?php

use function Pest\Livewire\livewire;

it('can run feature tests', function () {
    livewire('NonExisting::class');
})->throws(\Exception::class);
