<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkills extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skill_id',
        'value',
        'time',
        'level'
    ];

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getUserData()
    {
        return $this->hasMany(UserData::class, 'user_id', 'user_id');
    }

    public function getOrgin()
    {
        return $this->hasOne(Skills::class, 'skill_id', 'id');
    }
}
