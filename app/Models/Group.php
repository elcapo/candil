<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;

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

    public function activists(): BelongsToMany
    {
        return $this->belongsToMany(Activist::class)
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
