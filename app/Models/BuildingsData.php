<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingsData extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'build_id'
    ];

    public function getOrigin()
    {
        $this->hasOne(Buildings::class, 'id', 'build_id');
    }
}
