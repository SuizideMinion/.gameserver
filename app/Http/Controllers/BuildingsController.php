<?php

namespace App\Http\Controllers;

use App\Models\Buildings;
use App\Models\UserBuildings;
use App\Models\UserData;
use App\Models\UserResearchs;
use App\Models\UserUnitsBuild;
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
        $id = 1;
        $uT = 'UserBuildings';
        $T = 'Building';
        $Buildings = Buildings::with('getData')->get();

        $BuildingActive = UserBuildings::where('user_id', auth()->user()->id)->where('value', '1')->first();

        $Builds = [];

        foreach ( $Buildings as $Building )
        {
            $getData = $Building->getData->pluck('value', 'key');
            if ( ($getData['1.disable'] ?? 0) != 1 ) {
                $Builds[$Building->id] = [
                    'id' => $Building->id,
                    'name' => Lang($T. '.name.' . $Building->id),
                    'level' => (session($uT)[$Building->id]->level ?? 0) + 1,
                    'desc' => Lang($T. '.desc.' . $Building->id),
                    'max_level' => ($getData['1.max_level'] ?? ''),
                    'art' => $id,
                    'kordX' => ($getData['1.kordx'] ?? ''),
                    'kordY' => ($getData['1.kordy'] ?? ''),
                    'image' => ( $id == 1 ? 'technologies':'research') .'/'. ($getData['1.image'] ?? ''),
                    'ress1' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.ress1'] ?? '0'),
                    'ress2' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.ress2'] ?? '0'),
                    'ress3' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.ress3'] ?? '0'),
                    'ress4' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.ress4'] ?? '0'),
                    'ress5' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.ress5'] ?? '0'),
                    'build_time' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.tech_build_time'] ?? ''),
                    'canBuild' => canTechnik($id, $Building['id'], (session($uT)[$Building->id]->level ?? 0) + 1),
                    //'canTech' => canTech(2, $Building['id'], (session($uT)[$Building->id]->level ?? 0) + 1),
                    'hasBuilds' => hasBuildNeed($Building->id, $id, level: (session($uT)[$Building->id]->level ?? 0) + 1)
                ];
            }
        }
        return view('Buildings.index', compact('Builds', 'BuildingActive'));
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
        $idg = 1;
        $uT = 'UserBuildings';
        $T = 'Building';
        $Building = Buildings::where('id', $id)->with('getData')->first();
        $getData = $Building->getData->pluck('value', 'key');

            $array[$Building->id] = [
                'id' => $Building->id,
                'disable' => '0',
                'name' => Lang($T. '.name.' . $Building->id),
                'level' => (session($uT)[$Building->id]->level ?? 0) + 1,
                'desc' => Lang($T. '.desc.' . $Building->id),
                'max_level' => ($getData['1.max_level'] ?? ''),
                'art' => $idg,
                'kordX' => ($getData['1.kordx'] ?? ''),
                'kordY' => ($getData['1.kordy'] ?? ''),
                'image' => ( $idg == 1 ? 'technologies':'research') .'/'. ($getData['1.image'] ?? ''),
                'ress1' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.ress1'] ?? '0'),
                'ress2' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.ress2'] ?? '0'),
                'ress3' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.ress3'] ?? '0'),
                'ress4' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.ress4'] ?? '0'),
                'ress5' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.ress5'] ?? '0'),
                'build_time' => ($getData[( session($uT)[$Building->id]->level ?? 1 ). '.tech_build_time'] ?? ''),
                'canBuild' => canTechnik($idg, $Building['id'], (session($uT)[$Building->id]->level ?? 0) + 1),
                //'canTech' => canTech(2, $Building['id'], (session($uT)[$Building->id]->level ?? 0) + 1),
                'hasBuilds' => hasBuildNeed($Building->id, $idg, level: (session($uT)[$Building->id]->level ?? 0) + 1)
            ];
//        dd($array);
        return view('Buildings.show', compact('array'));
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
            if( !canTechnik(1, $Building->id, (session('UserBuildings')[$Building->id]->level ?? 0) + 1)['errors'] )
                //$Building->can()['value'] == 1)
            {
//                dd(canTechnik(1, $Building->id, (session('UserBuildings')[$Building->id]->level ?? 0) + 1));
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
