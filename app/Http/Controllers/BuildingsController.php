<?php

namespace App\Http\Controllers;

use App\Models\Buildings;
use App\Models\UserBuildings;
use App\Models\UserData;
use Illuminate\Http\Request;

class BuildingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $Buildings = Buildings::with('getData')->get();

        $BuildingActive = UserBuildings::where('user_id', auth()->user()->id)->where('value', '1')->first();

        $Builds = [];

        foreach ( $Buildings as $Building )
        {
            $getData = $Building->getData->pluck('value', 'key');
            if ( ($getData['1.disable'] ?? 0) != 1 ) {
                $Builds[$Building->id] = [
                    'id' => $Building->id,
                    'name' => Lang('Building.name.' . $Building->id),
                    'desc' => Lang('Building.desc.' . $Building->id),
                    'kordX' => ($getData['1.kordx'] ?? ''),
                    'kordY' => ($getData['1.kordy'] ?? ''),
                    'image' => ($getData['1.image'] ?? '')
                ];
            }

        }

        $Columns = new Buildings;
        $Columns = $Columns->getTableColumns();
        $Columns = array_diff($Columns, ['created_at', 'updated_at']);

        return view('Buildings.index', compact('Builds', 'Columns', 'BuildingActive'));
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $Building = Buildings::where('id', $id)->first();
        $BuildingActive = UserBuildings::where('user_id', auth()->user()->id)->where('value', '1')->first();

        return view('Buildings.show', compact('Building', 'BuildingActive'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit($id)
    {
        $BuildingActive = UserBuildings::where('user_id', auth()->user()->id)->where('value', '1')->first();

        if( !$BuildingActive )
        {
            $Building = Buildings::where('id', $id)->with('getData')->first();
            if($Building->can()['value'] == 1)
            {
                $getData = $Building->getData->pluck('value', 'key');

                UserBuildings::updateOrCreate(
                    [
                        'user_id' => auth()->user()->id,
                        'build_id' => $id,
                    ],
                    [
                        'time' => time() + ($getData[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) . '.tech_build_time'] / 100 * session('ServerData')['Tech.Speed.Percent']->value),
                        'value' => 1,
                        'level' => (session('UserBuildings')[$Building->id]->level ?? 0)
                    ]
                );
                UserData::where('user_id', auth()->user()->id)->where('key', 'ress')->update([
                    'value' => json_encode([
                        'ress1' => uRess()->ress1 - ($getData[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) . '.ress1'] ?? 0),
                        'ress2' => uRess()->ress2 - ($getData[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) . '.ress2'] ?? 0),
                        'ress3' => uRess()->ress3 - ($getData[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) . '.ress3'] ?? 0),
                        'ress4' => uRess()->ress4 - ($getData[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) . '.ress4'] ?? 0),
                        'ress5' => uRess()->ress5 - ($getData[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) . '.ress5'] ?? 0),
                    ])
                ]);
            } else return back()->with('error', 'Dir Fehlen Vorraussetzungen für dieses Gebäude!');
        } else return back()->with('error', 'Du Baust gerade was anderes');

        return redirect('/buildings');
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
}
