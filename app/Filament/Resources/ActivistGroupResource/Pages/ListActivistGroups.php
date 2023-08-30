<?php

namespace App\Filament\Resources\ActivistGroupResource\Pages;

use App\Filament\Resources\ActivistGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActivistGroups extends ListRecords
{
    protected static string $resource = ActivistGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
