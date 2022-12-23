<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Researchs;
use App\Models\ResearchsData;
use App\Models\Translations;
use Illuminate\Http\Request;

class ResearchsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $Researchs = Researchs::with('getData')->get();

        $Columns = new Researchs;
        $Columns = $Columns->getTableColumns();
        $Columns = array_diff($Columns, ['created_at', 'updated_at']);

        return view('admin.researchs.index', compact('Researchs', 'Columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.researchs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        Researchs::create([
            'desc' => $request->desc
        ]);

        return redirect('/admin/researchs');
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
        $Research = Researchs::whereId($id)->first();
//        dd($Research->getData()->pluck('value', 'key'));
        $ResearchsData = ResearchsData::where('research_id', $id)->get();
        $ResearchsTrans = Translations::where('key', 'Research.name.' . $id)->orWhere('key', 'Research.desc.' . $id)->orderBy('key')->get();

        return view('admin.researchs.edit', compact('Research', 'ResearchsData', 'ResearchsTrans'));
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
        Researchs::where('id', $id)->update([
            'desc' => $request->desc
        ]);
        if (!empty($request->key) and !empty($request->value))
            ResearchsData::create([
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

        return redirect('/admin/researchs/' . $id . '/edit');
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
        $file = fopen(storage_path() . '/csv/research.csv', 'r');
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
            $keyListData = ['group', 'disable', 'build_need', 'level', 'tech_build_time', 'ress1', 'ress2', 'ress3', 'ress4', 'ress5', 'max_level', 'image'];
            $keyListTrans = ['name_1', 'name_2', 'name_3', 'name_4', 'name_5', 'desc_1', 'desc_2', 'desc_3', 'desc_4'];
            Researchs::where('id', '>', 0)->delete();
            Translations::where('key', 'LIKE', 'Research%')->delete();
            $Return = '';
            if (!empty($array)) {
                foreach ($array as $a) {
                    if ($a['desc'] != '') {
                        Researchs::create([
                            'id' => $a['id'],
                            'desc' => $a['desc']
                        ]);
                        $Return .= 'create Research '. $a['desc'] .' -> ';
                        foreach ($keyListTrans as $Keys)
                        {
                            $Race = explode('_', $Keys);
                            if ($a[$Keys] != '')
                                Translations::create([
                                    'lang' => 'DE',
                                    'key' => 'Research.'. $Race[0] .'.' . $a['id'],
                                    'value' => $a[$Keys],
                                    'race' => $Race[1],
                                ]);
                            $Return .= 'create Translation Tech.name.' . $a['id'] .' -> ';
                        }
                    }

                    foreach ($keyListData as $Keys)
                    {
                        if ($a[$Keys] != '') {
                            ResearchsData::create([
                                'research_id' => $a['id'],
                                'key' => $Keys,
                                'value' => $a[$Keys],
                            ]);
                            $Return .= 'create Data ' . $Keys . '<br >';
                        }
                    }
                }
            }
        }
        return view('admin.researchs.csv', compact('Return'));
    }
}
