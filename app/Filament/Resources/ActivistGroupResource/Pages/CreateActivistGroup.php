<?php

namespace App\Filament\Resources\ActivistGroupResource\Pages;

use App\Filament\Resources\ActivistGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateActivistGroup extends CreateRecord
{
    protected static string $resource = ActivistGroupResource::class;

    public function getTitle(): string|Htmlable
    {
        return trans('candil/collaboration.actions.create');
    }
}
