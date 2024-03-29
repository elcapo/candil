<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as IsAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Activist extends Model implements Auditable
{
    use HasFactory, SoftDeletes, IsAuditable;

    protected $table = 'activists';

    protected $fillable = [
        'identity_number',
        'identity_type',
        'picture_filename',
        'first_name',
        'surname',
        'second_surname',
        'birth_date',
        'join_date',
        'email',
        'phone',
        'second_phone',
        'street',
        'city',
        'province',
        'zip_code',
    ];

    public function canBeDeleted(): bool
    {
        return ! $this->groups()->exists();
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'activist_group')
            ->using(ActivistGroup::class)
            ->withPivot([
                'join_date',
                'status',
                'leave_date',
            ]);
    }
}
