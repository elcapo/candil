<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activist extends Model
{
    use HasFactory;

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

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)
            ->using(ActivistGroup::class)
            ->withPivot([
                'join_date',
                'status',
                'leave_date',
            ]);
    }
}
