<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        return $this->belongsToMany(Activist::class);
    }
}
