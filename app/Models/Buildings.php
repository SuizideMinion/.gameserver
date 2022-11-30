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
                if ($getData['1.max_level'] == session('UserBuildings')[$this->id]->level) return ['notDisplay' => true, 'value' => 'vollAusGebaut'];
                $c = session('UserBuildings')[$this->id]->level + 1;
            }
            if (session('UserBuildings')[$this->id]->value == 1) {
                return ['notDisplay' => false, 'value' => 'imBau'];
            }
        }

        up:

        if ( isset( $getData[$c .'.build_need'] )) {
            $keys = json_decode($getData[$c .'.build_need']);
//            dd($keys, $c, $getData[$c .'.build_need']);

            foreach ($keys as $array) {
//                dd($keys, $array);
                $id = $array[0]->id;
                if ($array[0]->art == 1) {
                    // Gebäude
                    if (isset(session('UserBuildings')[$id])) {
//                        dd(session('UserBuildings')[$id]->level, $array[0]);
                        if (session('UserBuildings')[$id]->value == 2 and session('UserBuildings')[$id]->level == $array[0]->level) {
                            $c++;
                            goto up;
                        } else {
//                            return 'gebäudeFehlt -> '. $c;
                        }
                    } else {
//                        return 'gebäudeFehlt -> '. $c;
                    }

                } elseif ($array[0]->art == 2) {
                    // Research
                    if (isset(session('UserResearchs')[$id])) {
                        if (session('UserResearchs')[$id]->value == 2 and session('UserResearchs')[$id]->level == $array[0]->level) {
                            //
                        } else {
//                            return 'forschungFehlt -> '. $c;
                        }
                    }
                    else {
//                            return 'forschungFehlt -> '. $c;
                        }
                    }
//                dd($array[0], $key);
                }
            }
            $c--;
            if( $c > 0 )
            {
                if (isset($getData[$c .'.ress1']) AND (int)session('uData')['ress1']->value < (int)$getData[$c .'.ress1'])
                    return ['notDisplay' => false, 'error' => 'M Zuwenig', 'value' => 'lol'];
                if (isset($getData[$c .'.ress2']) AND (int)session('uData')['ress2']->value < (int)$getData[$c .'.ress2'])
                    return ['notDisplay' => false, 'error' => 'D Zuwenig', 'value' => 'lol'];
                if (isset($getData[$c .'.ress3']) AND (int)session('uData')['ress3']->value < (int)$getData[$c .'.ress3'])
                    return ['notDisplay' => false, 'error' => 'I Zuwenig', 'value' => 'lol'];
                if (isset($getData[$c .'.ress4']) AND (int)session('uData')['ress4']->value < (int)$getData[$c .'.ress4'])
                    return ['notDisplay' => false, 'error' => 'E Zuwenig', 'value' => 'lol'];
                if (isset($getData[$c .'.ress5']) AND (int)session('uData')['ress5']->value < (int)$getData[$c .'.ress5'])
                    return ['notDisplay' => false, 'error' => 'T Zuwenig', 'value' => 'lol'];
//                dd((int)session('uData')['ress1']->value, (int)$getData[$c .'.ress1'] );
                return ['notDisplay' => false, 'value' => 1];
            }
            return ['notDisplay' => true, 'value' => 'lol'];
        }
    }
