<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchsData extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'research_id'
    ];

    public function getOrigin()
    {
        $this->hasOne(ResearchsData::class, 'id', 'research_id');
    }
}
