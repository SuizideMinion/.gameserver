<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUnitsBuild extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'unit_id',
        'value',
        'time',
        'quantity'
    ];

    public function getUserData()
    {
        return $this->hasMany(UserData::class, 'user_id', 'user_id');
    }
}
