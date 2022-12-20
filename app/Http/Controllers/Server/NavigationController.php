<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\Buildings;
use App\Models\UserBuildings;
use App\Models\UserResearchs;
use App\Models\UserUnitsBuild;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $Buildings = Researchs::with('getData')
//            ->join('researchs_data', 'researchs_data.research_id', 'researchs.id')
//            ->where('researchs_data.key', 'group')
//            ->orderBy('researchs_data.value')
//            ->get()
//            ->groupBy('value');
        $Buildings = Buildings::with('getData')->get();

        $BuildingActive = UserBuildings::where('user_id', auth()->user()->id)->where('value', '1')->first();
        $ResearchActive = UserResearchs::where('user_id', auth()->user()->id)->where('value', '1')->first();
        $userUnitsBuilds = UserUnitsBuild::where('user_id', auth()->user()->id)->where('unit_id', 1)->sum('quantity');
//        dd($userUnitsBuilds);

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

        return view('Server.Navigation.index', compact('Builds', 'Columns', 'BuildingActive', 'ResearchActive', 'userUnitsBuilds'));
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
}
