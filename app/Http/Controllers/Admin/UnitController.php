<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translations;
use App\Models\Units;
use App\Models\UnitsData;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $Units = Units::with('getData')->get();

        $Columns = new Units;
        $Columns = $Columns->getTableColumns();
        $Columns = array_diff($Columns, ['created_at', 'updated_at']);

        return view('admin.Units.index', compact('Units', 'Columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.Units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        Units::create([
            'desc' => $request->desc
        ]);

        return redirect('/admin/Units');
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
        $Unit = Units::whereId($id)->first();
//        dd($Unit->getData()->pluck('value', 'key'));
        $UnitsData = UnitsData::where('build_id', $id)->get();
        $UnitsTrans = Translations::where('key', 'Unit.name.' . $id)->orWhere('key', 'Unit.desc.' . $id)->orderBy('key')->get();

        return view('admin.Units.edit', compact('Unit', 'UnitsData', 'UnitsTrans'));
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
        Units::where('id', $id)->update([
            'desc' => $request->desc
        ]);
        if (!empty($request->key) and !empty($request->value))
            UnitsData::create([
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

        return redirect('/admin/Units/' . $id . '/edit');
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
        set_time_limit(500);
        $file = fopen(storage_path() . '/csv/Units.csv', 'r');
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
            $keyListData = [ 'name', 'race', 'type', 'points', 'build_need', 'tech_build_time', 'ress1', 'ress2', 'ress3', 'ress4', 'ress5', 'image'];
            $keyListTrans = ['name', 'desc'];
            Units::where('id', '>', 0)->delete();
            Translations::where('key', 'LIKE', 'Unit%')->orWhere('key', 'LIKE', 'Unit%')->orWhere('key', 'LIKE', 'entity%')->delete();
            $Return = '';
            if (!empty($array)) {
                foreach ($array as $a) {
                    if ($a['desc1'] != '') {
                        Units::create([
                            'id' => $a['id'],
                            'desc' => $a['desc1'],
                            'type' => $a['type'],
                            'disable' => $a['disable']
                        ]);
                        $Return .= 'create Unit '. $a['desc1'] .' -> ';
                    }
                    else
                    {
                        foreach ($keyListData as $Keys) {
                            if ($a[$Keys] != '') {
                                UnitsData::create([
                                    'unit_id' => $a['id'],
                                    'key' => $Keys,
                                    'value' => $a[$Keys],
                                    'race' => $a['race'],
                                ]);
                                $Return .= 'create UnitData ' . $Keys . '<br >';
                            }
                        }

                        foreach ($keyListTrans as $Keys)
                        {
                            if ($a[$Keys] != '')
                                Translations::create([
                                    'lang' => 'DE',
                                    'key' => 'Unit.'. $Keys .'.' . $a['id'],
                                    'value' => $a[$Keys],
                                    'plural' => ( $Keys == 'name' ? $a['plural']:'' ),
                                    'race' => $a['race'],
                                ]);
                            $Return .= 'create Unit Unit.name.' . $a['id'] .' -> ';
                        }
                    }
                }
            }
        }
        return view('admin.Units.csv', compact('Return'));
    }
}
