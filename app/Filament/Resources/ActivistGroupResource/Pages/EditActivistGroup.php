<?php

namespace App\Filament\Resources\ActivistGroupResource\Pages;

use App\Filament\EditAuditableRecord;
use App\Filament\Resources\ActivistGroupResource;
use Illuminate\Contracts\Support\Htmlable;

class EditActivistGroup extends EditAuditableRecord
{
    protected static string $resource = ActivistGroupResource::class;

    public function getTitle(): string|Htmlable
    {
        return trans('candil/collaboration.actions.edit');
    }
}
