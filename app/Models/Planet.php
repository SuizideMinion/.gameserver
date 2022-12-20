<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'y',
        'x',
        'size',
        'posAtMap',
        'img',
        'user_id'
    ];

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getUserData()
    {
        return $this->hasMany(UserData::class, 'user_id', 'user_id');
    }

    public function getData()
    {
        return $this->hasMany(PlanetData::class);
    }

}
