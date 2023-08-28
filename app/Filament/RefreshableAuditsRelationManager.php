<?php

namespace App\Filament;

use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class RefreshableAuditsRelationManager extends AuditsRelationManager
{
    protected $listeners = ['refreshAuditsRelationManager' => '$refresh'];
}
