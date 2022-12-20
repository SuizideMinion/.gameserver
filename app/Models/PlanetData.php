<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanetData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'planet_id',
        'key',
        'value'
    ];
}
