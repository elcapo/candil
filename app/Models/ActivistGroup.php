<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ActivistGroup extends Pivot
{
    use HasFactory;

    protected $table = 'activist_group';

    protected $fillable = [
        'activist_id',
        'group_id',
        'join_date',
        'status',
    ];
}
