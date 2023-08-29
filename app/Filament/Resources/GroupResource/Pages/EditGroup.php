<?php

namespace App\Filament\Resources\GroupResource\Pages;

use App\Filament\EditAuditableRecord;
use App\Filament\Resources\GroupResource;
use Filament\Actions;

class EditGroup extends EditAuditableRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\ForceDeleteAction::make(),
        ];
    }
}
