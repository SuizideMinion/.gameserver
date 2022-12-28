<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillData extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'skill_id'
    ];

    public function getOrigin()
    {
        $this->hasOne(Skills::class, 'id', 'skill_id');
    }
}
