<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivistGroup extends Model
{
    use HasFactory;

    protected $table = 'activist_group';

    protected $fillable = [
        'activist_id',
        'group_id',
    ];
}
