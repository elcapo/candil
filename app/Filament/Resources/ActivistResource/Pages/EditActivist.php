<?php

namespace App\Filament\Resources\ActivistResource\Pages;

use App\Filament\Resources\ActivistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActivist extends EditRecord
{
    protected static string $resource = ActivistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
