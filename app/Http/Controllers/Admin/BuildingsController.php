<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buildings;
use App\Models\BuildingsData;
use App\Models\Translations;
use App\Models\User;
use App\Models\UserBuildings;
use Illuminate\Http\Request;

class BuildingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $Buildings = Buildings::with('getData')->get();

        $Columns = new Buildings;
        $Columns = $Columns->getTableColumns();
        $Columns = array_diff($Columns, ['created_at', 'updated_at']);

        return view('admin.buildings.index', compact('Buildings', 'Columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.buildings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        Buildings::create([
            'desc' => $request->desc
        ]);

        return redirect('/admin/buildings');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $Building = Buildings::whereId($id)->first();
//        dd($Building->getData()->pluck('value', 'key'));
        $BuildingsData = BuildingsData::where('build_id', $id)->get();
        $BuildingsTrans = Translations::where('key', 'Building.name.' . $id)->orWhere('key', 'Building.desc.' . $id)->orderBy('key')->get();

        return view('admin.buildings.edit', compact('Building', 'BuildingsData', 'BuildingsTrans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        Buildings::where('id', $id)->update([
            'desc' => $request->desc
        ]);
        if (!empty($request->key) and !empty($request->value))
            BuildingsData::create([
                'key' => $request->key,
                'value' => $request->value,
                'build_id' => $id
            ]);
        if (!empty($request->Tkey) AND !empty($request->Tvalue) AND !empty($request->race) AND !empty($request->lang))
            Translations::create([
                'key' => $request->Tkey,
                'value' => $request->Tvalue,
                'race' => $request->race,
                'lang' => $request->lang
            ]);

        return redirect('/admin/buildings/' . $id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getDataCsv()
    {
        $file = fopen(storage_path() . '/csv/buildings.csv', 'r');
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
            $keyListData = ['build_need', 'level', 'tech_build_time', 'ress1', 'ress2', 'ress3', 'ress4', 'ress5', 'max_level', 'image'];
            $keyListTrans = ['name_1', 'name_2', 'name_3', 'name_4', 'name_5', 'desc_1', 'desc_2', 'desc_3', 'desc_4'];
            Buildings::where('id', '>', 0)->delete();
            Translations::where('key', 'LIKE', 'Tech%')->orWhere('key', 'LIKE', 'tech%')->orWhere('key', 'LIKE', 'Building%')->delete();
            $Return = '';
            if (!empty($array)) {
                foreach ($array as $a) {
                    if ($a['desc'] != '') {
                        Buildings::create([
                            'id' => $a['id'],
                            'desc' => $a['desc']
                        ]);
                        $Return .= 'create Building '. $a['desc'] .' -> ';
                        foreach ($keyListTrans as $Keys)
                        {
                            $Race = explode('_', $Keys);
                            if ($a[$Keys] != '')
                                Translations::create([
                                    'lang' => 'DE',
                                    'key' => 'Building.'. $Race[0] .'.' . $a['id'],
                                    'value' => $a[$Keys],
                                    'race' => $Race[1],
                                ]);
                            $Return .= 'create Translation Tech.name.' . $a['id'] .' -> ';
                        }
                    }

                    foreach ($keyListData as $Keys)
                    {
                        if ($a[$Keys] != '') {
                            BuildingsData::create([
                                'build_id' => $a['id'],
                                'key' => $a['level'] . '.' . $Keys,
                                'value' => $a[$Keys],
                            ]);
                            $Return .= 'create Data ' . $a['level'] . '.' . $Keys . '<br >';
                        }
                    }
                }
            }
        }
        return view('admin.buildings.csv', compact('Return'));
    }
}
