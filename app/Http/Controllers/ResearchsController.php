<?php

namespace App\Http\Controllers;

use App\Models\Researchs;
use App\Models\ResearchsData;
use App\Models\UserData;
use App\Models\UserResearchs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ResearchsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $Researchs = Researchs::with('getData')
            ->join('researchs_data', 'researchs_data.research_id', 'researchs.id')
            ->where('researchs_data.key', '1.group')
            ->orderBy('researchs_data.value')
            ->get()
            ->groupBy('value');

        $ResearchActive = UserResearchs::where('user_id', auth()->user()->id)->where('value', '1')->first();

        return view('Researchs.index', compact('Researchs', 'ResearchActive'));
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
        $Researchs = Researchs::with('getData')
            ->join('researchs_data', 'researchs_data.research_id', 'researchs.id')
            ->select('researchs_data.value as researchs_data.research_id', 'researchs.*')
            ->where('researchs_data.key', '1.group')
            ->where('value', $id)
//            ->with('getData')
            ->get();

        $array = [];
        $uT = 'UserResearchs';
        $T = 'Research';
        $ids = 2;

        foreach ($Researchs AS $Research)
        {

            $getData = $Research->getData->pluck('value', 'key');
            $array[$Research->id] = [
                'id' => $Research->id,
                'name' => Lang($T. '.name.' . $Research->id),
                'disable' => ($getData['1.disable'] ?? 0),
                'level' => (session($uT)[$Research->id]->level ?? 0) + 1,
                'desc' => Lang($T. '.desc.' . $Research->id),
                'max_level' => ($getData['1.max_level'] ?? ''),
                'art' => $ids,
                'kordX' => ($getData['1.kordx'] ?? ''),
                'kordY' => ($getData['1.kordy'] ?? ''),
                'image' => ( $ids == 1 ? 'technologies':'research') .'/'. ($getData['1.image'] ?? ''),
                'ress1' => ($getData[( session($uT)[$Research->id]->level ?? 1 ). '.ress1'] ?? '0'),
                'ress2' => ($getData[( session($uT)[$Research->id]->level ?? 1 ). '.ress2'] ?? '0'),
                'ress3' => ($getData[( session($uT)[$Research->id]->level ?? 1 ). '.ress3'] ?? '0'),
                'ress4' => ($getData[( session($uT)[$Research->id]->level ?? 1 ). '.ress4'] ?? '0'),
                'ress5' => ($getData[( session($uT)[$Research->id]->level ?? 1 ). '.ress5'] ?? '0'),
                'build_time' => ($getData[( session($uT)[$Research->id]->level ?? 1 ). '.tech_build_time'] ?? ''),
                'canBuild' => canTechnik($ids, $Research['id'], (session($uT)[$Research->id]->level ?? 0) + 1),
                //'canTech' => canTech(2, $Building['id'], (session($uT)[$Building->id]->level ?? 0) + 1),
                'hasBuilds' => hasBuildNeed($Research->id, $ids, level: (session($uT)[$Research->id]->level ?? 0) + 1)
            ];
        }

        return view('Researchs.show', compact('array'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $ResearchActive = UserResearchs::where('user_id', auth()->user()->id)->where('value', '1')->first();

        if( !$ResearchActive )
        {
            $Research = Researchs::where('id', $id)->with('getData')->first();

            if( !canTechnik(2, $Research->id, (session('UserBuildings')[$Research->id]->level ?? 0) + 1)['errors'] )
            {
                $getData = $Research->getData->pluck('value', 'key');

                    UserResearchs::updateOrCreate(
                        [
                            'user_id' => auth()->user()->id,
                            'research_id' => $id,
                        ],
                        [
                            'level' => 0,
                            'time' => time() + ($getData[((session('UserResearchs')[$Research->id]->level ?? 0) + 1) . '.tech_build_time'] / 100 * session('ServerData')['Tech.Speed.Percent']->value),
                            'value' => 1,
                        ]
                    );
                    UserData::where('user_id', auth()->user()->id)->where('key', 'ress')->update([
                        'value' => json_encode([
                            'ress1' => uRess()->ress1 - ($getData[((session('UserResearchs')[$Research->id]->level ?? 0) + 1) . '.ress1'] ?? 0),
                            'ress2' => uRess()->ress2 - ($getData[((session('UserResearchs')[$Research->id]->level ?? 0) + 1) . '.ress2'] ?? 0),
                            'ress3' => uRess()->ress3 - ($getData[((session('UserResearchs')[$Research->id]->level ?? 0) + 1) . '.ress3'] ?? 0),
                            'ress4' => uRess()->ress4 - ($getData[((session('UserResearchs')[$Research->id]->level ?? 0) + 1) . '.ress4'] ?? 0),
                            'ress5' => uRess()->ress5 - ($getData[((session('UserResearchs')[$Research->id]->level ?? 0) + 1) . '.ress5'] ?? 0),
                        ])
                    ]);
            } else return back()->with('error', 'Dir Fehlen Vorraussetzungen für dieses Gebäude!');
        } else return back()->with('error', 'Du Baust gerade was anderes');

        return redirect('buildings');//redirect('/researchs');
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
