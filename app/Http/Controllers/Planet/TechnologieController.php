<?php

namespace App\Http\Controllers\Planet;

use App\Http\Controllers\Controller;
use App\Models\Buildings;
use App\Models\Researchs;
use App\Models\UserBuildings;
use App\Models\UserResearchs;
use App\Models\UserUnitsBuild;
use Illuminate\Http\Request;

class TechnologieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $Buildings = Buildings::with('getData')->get();

        $Builds = [];

        foreach ( $Buildings as $Building )
        {
            $getData = $Building->getData->pluck('value', 'key');
            if ( ($getData['1.disable'] ?? 0) != 1 ) {
                $Builds[$Building->id] = [
                    'id' => $Building->id,
                    'name' => Lang('Building.name.' . $Building->id),
                    'level' => (session('UserBuildings')[$Building->id]->level ?? 0) + 1,
                    'desc' => Lang('Building.desc.' . $Building->id),
                    'max_level' => ($getData['1.max_level'] ?? ''),
                    'art' => 1,
                    'kordX' => ($getData['1.kordx'] ?? ''),
                    'kordY' => ($getData['1.kordy'] ?? ''),
                    'image' => 'technologies/'. ($getData['1.image'] ?? ''),
                    'ress1' => ($getData[( session('UserBuildings')[$Building->id]->level ?? 1 ). '.ress1'] ?? '0'),
                    'ress2' => ($getData[( session('UserBuildings')[$Building->id]->level ?? 1 ). '.ress2'] ?? '0'),
                    'ress3' => ($getData[( session('UserBuildings')[$Building->id]->level ?? 1 ). '.ress3'] ?? '0'),
                    'ress4' => ($getData[( session('UserBuildings')[$Building->id]->level ?? 1 ). '.ress4'] ?? '0'),
                    'ress5' => ($getData[( session('UserBuildings')[$Building->id]->level ?? 1 ). '.ress5'] ?? '0'),
                    'build_time' => ($getData[( session('UserBuildings')[$Building->id]->level ?? 1 ). '.tech_build_time'] ?? ''),
                    'canBuild' => canTechnik(1, $Building['id'], (session('UserBuildings')[$Building->id]->level ?? 0) + 1),
                    'canTech' => canTech(1, $Building['id'], (session('UserBuildings')[$Building->id]->level ?? 0) + 1),
                    'hasBuilds' => hasBuildNeed($Building->id, 1, level: (session('UserBuildings')[$Building->id]->level ?? 0) + 1)
                ];
            }
        }

        return view('Planet.Technologie.index', compact('Builds'));
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
        if ( $id == 1 )
        {
            $uT = 'UserBuildings';
            $T = 'Building';
            $Buildings = Buildings::with('getData')->get();
        } else {
            $uT = 'UserResearchs';
            $T = 'Research';
            $Buildings = Researchs::with('getData')->get();
        }

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

        return view('Planet.Technologie.index', compact('Builds', 'id'));
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
}
