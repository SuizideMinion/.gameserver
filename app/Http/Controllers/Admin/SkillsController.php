<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillData;
use App\Models\Skills;
use App\Models\Translations;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Buildings = Skills::get();

        $Columns = new Skills;
        $Columns = $Columns->getTableColumns();
        $Columns = array_diff($Columns, ['created_at', 'updated_at']);

        return view('admin.skills.index', compact('Buildings', 'Columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getDataCsv()
    {
        $file = fopen(storage_path() . '/csv/skills.csv', 'r');
        $lines = [];
        while (($line = fgetcsv($file)) !== FALSE) {
            $lines[] = $line;
        }
        fclose($file);

        if (!empty($lines)) {
            $keys = [];
            foreach ($lines[0] as $key) {
                $keys[] = strtolower($key);
            }

            $i = 0;
            $array = [];
            array_shift($lines);
            foreach ($lines as $line) {
                $k = 0;
                foreach ($line as $l) {
                    $array[$i][$keys[$k]] = $l;

                    $k++;
                }

                $i++;
            }
            $keyListData = ['disable', 'race', 'desc1', 'image', 'name', 'desc'];
            $keyListTrans = ['name', 'desc'];
            Skills::where('id', '>', 0)->delete();
            Translations::where('key', 'LIKE', 'Skill%')->delete();
            $Return = '';
            if (!empty($array)) {
                foreach ($array as $a) {
                    if ($a['desc'] != '') {
                        Skills::create([
                            'id' => $a['id'],
                            'desc' => $a['desc']
                        ]);
                        $Return .= 'create Skill '. $a['desc'] .' -> ';
                        foreach ($keyListTrans as $Keys)
                        {
                            if ($a[$Keys] != '')
                                Translations::create([
                                    'lang' => 'DE',
                                    'key' => 'Skills.'. $a['race'] .'.' . $a['id'],
                                    'value' => $a[$Keys],
                                    'race' => $a['race'],
                                ]);
                            $Return .= 'create Translation Skill.name.' . $a['id'] .' -> ';
                        }
                    }

                    foreach ($keyListData as $Keys)
                    {
                        if ($a[$Keys] != '') {
                            SkillData::create([
                                'skill_id' => $a['id'],
                                'key' => $Keys,
                                'value' => $a[$Keys],
                            ]);
                            $Return .= 'create Data ' . $Keys . '<br >';
                        }
                    }
                }
            }
        }
        return view('admin.skills.csv', compact('Return'));
    }
}
