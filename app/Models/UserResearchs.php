<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResearchs extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'research_id',
        'value',
        'time',
        'level'
    ];
}
