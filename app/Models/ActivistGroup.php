<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as IsAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ActivistGroup extends Pivot implements Auditable
{
    use HasFactory, SoftDeletes, IsAuditable;

    protected $table = 'activist_group';

    protected $fillable = [
        'activist_id',
        'group_id',
        'join_date',
        'status',
        'leave_date',
    ];

    public function activist(): BelongsTo
    {
        return $this->belongsTo(Activist::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}