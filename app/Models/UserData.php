<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'user_id'
    ];

    public function getData()
    {
        return $this->hasMany(UserData::class);
    }
}
