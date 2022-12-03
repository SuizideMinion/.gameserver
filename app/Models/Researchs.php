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

    public function pluck()
    {
        return $this->getData->pluck('value', 'key');
    }

    public function can()
    {
        $getData = $this->getData->pluck('value', 'key');
        dd(session('UserResearchs'));
        if (isset(session('UserResearchs')[$this->id])) {
            if (session('UserResearchs')[$this->id]->value == 2) {
                if (1 == session('UserResearchs')[$this->id]->level) return ['notDisplay' => true, 'value' => 'vollAusGebaut'];
            }
            if (session('UserResearchs')[$this->id]->value == 1) {
                return ['notDisplay' => false, 'value' => 'imBau'];
            }
        }

        up:

        if (isset($getData['build_need'])) {
            $keys = json_decode($getData['build_need']);

            foreach ($keys as $array)
            {
                $id = $array[0]->id;
                if ($array[0]->art == 1) {
                    // Gebäude
                    if (isset(session('UserBuildings')[$id])) {
                        if (session('UserBuildings')[$id]->value == 2 and session('UserBuildings')[$id]->level < $array[0]->level) {
                            return ['notDisplay' => true, 'value' => 'lol'];
                        }
                    } else return ['notDisplay' => true, 'value' => 'lol'];

                } elseif ($array[0]->art == 2) {
                    // Research
                    if (isset(session('UserResearchs')[$id])) {
                        if (session('UserResearchs')[$id]->value != 2) {
                            return ['notDisplay' => true, 'value' => 'lol'];
                            //
                        }
                    } else return ['notDisplay' => true, 'value' => 'lol'];
                }
            }
        }
        if (isset($getData['ress1']) and (int)uRess()->ress1 < (int)$getData['ress1'])
            return ['notDisplay' => false, 'error' => 'M Zuwenig', 'value' => 'lol'];
        if (isset($getData['ress2']) and (int)uRess()->ress2 < (int)$getData['ress2'])
            return ['notDisplay' => false, 'error' => 'D Zuwenig', 'value' => 'lol'];
        if (isset($getData['ress3']) and (int)uRess()->ress3 < (int)$getData['ress3'])
            return ['notDisplay' => false, 'error' => 'I Zuwenig', 'value' => 'lol'];
        if (isset($getData['ress4']) and (int)uRess()->ress4 < (int)$getData['ress4'])
            return ['notDisplay' => false, 'error' => 'E Zuwenig', 'value' => 'lol'];
        if (isset($getData['ress5']) and (int)uRess()->ress5 < (int)$getData['ress5'])
            return ['notDisplay' => false, 'error' => 'T Zuwenig', 'value' => 'lol'];

        return ['notDisplay' => false, 'value' => 1];
//        return ['notDisplay' => true, 'value' => 'lol'];
    }
}
