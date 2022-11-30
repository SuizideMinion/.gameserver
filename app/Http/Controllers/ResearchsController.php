<?php

namespace App\Http\Controllers;

use App\Models\Researchs;
use App\Models\ResearchsData;
use App\Models\UserData;
use App\Models\UserResearchs;
use Illuminate\Http\Request;

class ResearchsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $Researchs = Researchs::with('getData')->get();

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
        $Researchs = Researchs::get();

        foreach ($Researchs AS $Research)
        {
            $ResearchData = ResearchsData::where('research_id', $Research->id)->get()->pluck('value', 'key');

            print_r(json_decode($ResearchData['build_need']));
        }
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
            if($Research->can()['value'] == 1)
            {
                $getData = $Research->getData->pluck('value', 'key');

                UserResearchs::updateOrCreate(
                    [
                        'user_id' => auth()->user()->id,
                        'research_id' => $id,
                        'level' => 0
                    ],
                    [
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

        return redirect('/researchs');
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
