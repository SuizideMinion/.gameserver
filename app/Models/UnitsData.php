<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitsData extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'unit_id',
        'race'
    ];
}
