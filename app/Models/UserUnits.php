<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUnits extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'unit_id',
        'value',
        'fleet'
    ];
}
