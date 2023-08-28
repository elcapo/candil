<?php

namespace App\Filament;

use Filament\Resources\Pages\EditRecord;

abstract class EditAuditableRecord extends EditRecord
{
    protected $listeners = [
        'auditRestored' => 'refreshForm',
    ];

    public function refreshForm()
    {
        $this->fillForm();
    }

    public function afterSave()
    {
        $this->dispatch('refreshAuditsRelationManager');
    }
}
