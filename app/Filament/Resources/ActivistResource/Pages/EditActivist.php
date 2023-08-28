<?php

namespace App\Filament\Resources\ActivistResource\Pages;

use App\Filament\EditAuditableRecord;
use App\Filament\Resources\ActivistResource;
use Filament\Actions;

class EditActivist extends EditAuditableRecord
{
    protected static string $resource = ActivistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
