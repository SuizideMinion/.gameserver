<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buildings extends Model
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
        return $this->hasMany(BuildingsData::class, 'build_id', 'id');
    }

    public function pluck()
    {
        return $this->getData->pluck('value', 'key');
    }

    public function can()
    {
        $getData = $this->getData->pluck('value', 'key');
        $c = 1;
        if (isset(session('UserBuildings')[$this->id])) {
            if (session('UserBuildings')[$this->id]->value == 2) {
                if ($getData['1.max_level'] == session('UserBuildings')[$this->id]->level) return ['notDisplay' => true, 'value' => Lang('tech.finish')];
                $c = session('UserBuildings')[$this->id]->level + 1;
            }
            if (session('UserBuildings')[$this->id]->value == 1) {
                return ['notDisplay' => false, 'value' => 'imBau'];
            }
        }

        if (isset($getData[$c . '.build_need'])) {
            $keys = json_decode($getData[$c . '.build_need']);
//            if( $this->id == 14) dd($keys);
            foreach ($keys as $array)
            {
                $id = $array[0]->id;
                if ($array[0]->art == 1) {
                    // Gebäude
                    if (isset(session('UserBuildings')[$id])) {
                        if (session('UserBuildings')[$id]->value == 2) {
                            if (session('UserBuildings')[$id]->level < $array[0]->level) return ['notDisplay' => true, 'value' => 'lol1'];
                        }
                    } else return ['notDisplay' => true, 'value' => 'lol2'];

                } elseif ($array[0]->art == 2) {
                    // Research
                    if (isset(session('UserResearchs')[$id])) {
                        if (session('UserResearchs')[$id]->value != 2) {
                            return ['notDisplay' => true, 'value' => 'lol3'];
                            //
                        }
                    } else return ['notDisplay' => true, 'value' => 'lol4'];
                }
            }
        }
        if ($c > 2 ) $c--;
        if (!isset($getData[$c . '.build_need'])) {
            if ((int)uRess()->ress1 < (int)$getData[$c . '.ress1'])
                return ['notDisplay' => false, 'error' => 'M Zuwenig', 'value' => 'lol5'];
            if ((int)uRess()->ress2 < (int)$getData[$c . '.ress2'])
                return ['notDisplay' => false, 'error' => 'D Zuwenig', 'value' => 'lol6'];
            if ((int)uRess()->ress3 < (int)$getData[$c . '.ress3'])
                return ['notDisplay' => false, 'error' => 'I Zuwenig', 'value' => 'lol7'];
            if ((int)uRess()->ress4 < (int)$getData[$c . '.ress4'])
                return ['notDisplay' => false, 'error' => 'E Zuwenig', 'value' => 'lol8'];
            if ((int)uRess()->ress5 < (int)$getData[$c . '.ress5'])
                return ['notDisplay' => false, 'error' => 'T Zuwenig', 'value' => 'lol9'];
//            dd($getData[$c . '.ress1'], (int)uRess()->ress1 , (int)$getData[$c . '.ress1']);

            return ['notDisplay' => false, 'value' => 1];
        }
        return ['notDisplay' => true, 'value' => 'lol10'];
    }
}
