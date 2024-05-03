<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivistGroup extends Pivot
{
    use HasFactory, SoftDeletes;

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