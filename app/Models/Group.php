<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as IsAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Group extends Model implements Auditable
{
    use HasFactory, SoftDeletes, IsAuditable;

    protected $fillable = [
        'name',
        'type',
        'email',
        'phone',
        'street',
        'city',
        'province',
        'zip_code',
    ];

    public function canBeDeleted(): bool
    {
        return ! $this->activists()->exists();
    }

    public function activists(): BelongsToMany
    {
        return $this->belongsToMany(Activist::class, 'activist_group')
            ->using(ActivistGroup::class)
            ->withPivot([
                'join_date',
                'status',
                'leave_date',
            ]);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'part_of_group_id');
    }
}
