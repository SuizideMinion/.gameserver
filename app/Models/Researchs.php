<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Researchs extends Model
{
    use HasFactory;

    protected $fillable = [
        'desc',
        'id'
    ];

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function getData()
    {
        return $this->hasMany(ResearchsData::class, 'research_id', 'id');
    }
}
