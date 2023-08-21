<?php

namespace App\Filament\Resources\ActivistResource\Pages;

use App\Filament\Resources\ActivistResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActivists extends ListRecords
{
    protected static string $resource = ActivistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
