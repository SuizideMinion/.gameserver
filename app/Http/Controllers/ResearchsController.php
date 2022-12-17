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
            ->where('researchs_data.key', 'group')
            ->orderBy('researchs_data.value')
            ->get()
            ->groupBy('value');

        $ResearchActive = UserResearchs::where('user_id', auth()->user()->id)->where('value', '1')->first();

        $Columns = new Researchs;
        $Columns = $Columns->getTableColumns();
        $Columns = array_diff($Columns, ['created_at', 'updated_at']);

        return view('Researchs.index', compact('Researchs', 'Columns', 'ResearchActive'));
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
        $Researchs = Researchs::with('getData')
            ->join('researchs_data', 'researchs_data.research_id', 'researchs.id')
            ->select('researchs_data.value as researchs_data.research_id', 'researchs.*')
            ->where('researchs_data.key', 'group')
            ->where('value', $id)
//            ->with('getData')
            ->get();

//        dd($Researchs);

        $array = [];
//        $Researchs -> test = $Researchs -> getData -> keyBy('research_id');
//        $Researchs -> addVisible('getData');
//        $Researchs->setRelation('test', $Researchs->getData->keyBy('research_id'));
//        $ResearchData = ;
        foreach ($Researchs AS $Research)
        {
            $ResearchData = $Research->getData->keyBy('key');
//            dd($ResearchData);

            $array[$Research->id] = [
                'name' => Lang('Research.name.'. $Research->id),
                'desc' => Lang('Research.desc.'. $Research->id),
                'id' => $Research->id,
                'build_need' => ($ResearchData['build_need'] ?? ''),
                'build_time' => ($ResearchData['tech_build_time'] ?? ''),
                'ress1' => ($ResearchData['ress1'] ?? '0'),
                'ress2' => ($ResearchData['ress2'] ?? '0'),
                'ress3' => ($ResearchData['ress3'] ?? '0'),
                'ress4' => ($ResearchData['ress4'] ?? '0'),
                'ress5' => ($ResearchData['ress5'] ?? '0'),
                'image' => ($ResearchData['image'] ?? '0'),
                'hasBuilds' => hasBuildNeed($Research->id)
            ];
        }
//        dd($array);

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

            if( canTech(2, $id) )
            {
                $getData = $Research->getData->pluck('value', 'key');

                UserResearchs::updateOrCreate(
                    [
                        'user_id' => auth()->user()->id,
                        'research_id' => $id,
                    ],
                    [
                        'level' => 0,
                        'time' => time() + ($getData['tech_build_time'] / 100 * session('ServerData')['Tech.Speed.Percent']->value),
                        'value' => 1,
                    ]
                );
                UserData::where('user_id', auth()->user()->id)->where('key', 'ress')->update([
                    'value' => json_encode([
                        'ress1' => uRess()->ress1 - ($getData['ress1'] ?? 0),
                        'ress2' => uRess()->ress2 - ($getData['ress2'] ?? 0),
                        'ress3' => uRess()->ress3 - ($getData['ress3'] ?? 0),
                        'ress4' => uRess()->ress4 - ($getData['ress4'] ?? 0),
                        'ress5' => uRess()->ress5 - ($getData['ress5'] ?? 0),
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
