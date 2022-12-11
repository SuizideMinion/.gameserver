<?php

namespace App\Http\Controllers;

use App\Models\Units;
use App\Models\UnitsData;
use App\Models\UserData;
use App\Models\UserUnitsBuild;
use Illuminate\Http\Request;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $userData = UserData::where('user_id', auth()->user()->id)->first()->pluck('value', 'key');
        $userUnitsBuilds = UserUnitsBuild::where('user_id', auth()->user()->id)->get();
        $Units = Units::where('type', 2)->where('disable', 0)->with('getData')->get();

        return view('units.index', compact('Units', 'userData', 'userUnitsBuilds'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $Units = Units::where('type', 2)->where('disable', 0)->with('getData')->get();
//        if( $request->1 >= 0 AND $request->2 >= 0 AND $request->3 >= 0 AND $request->4 >= 0) {

        $mcost = 0;
        $dcost = 0;
        $icost = 0;
        $ecost = 0;
        $tcost = 0;

        foreach($Units AS $Unit)
        {
            if($request[$Unit->id] > 0)
            {
                $getData = $Unit->getData->where('race', uData('race'))->pluck('value', 'key');
                $mcost = $mcost + ($request[$Unit->id] * $getData['ress1']);
                $dcost = $dcost + ($request[$Unit->id] * $getData['ress2']);
                $icost = $icost + ($request[$Unit->id] * $getData['ress3']);
                $ecost = $ecost + ($request[$Unit->id] * $getData['ress4']);
                $tcost = $tcost + ($request[$Unit->id] * $getData['ress5']);
            }
        }

        if($mcost > uRess()->ress1) return back()->with('error', 'Zu Wenig Ressurcen');
        if($dcost > uRess()->ress2) return back()->with('error', 'Zu Wenig Ressurcen');
        if($icost > uRess()->ress3) return back()->with('error', 'Zu Wenig Ressurcen');
        if($ecost > uRess()->ress4) return back()->with('error', 'Zu Wenig Ressurcen');
        if($tcost > uRess()->ress5) return back()->with('error', 'Zu Wenig Ressurcen');

        ressChanceDown(auth()->user()->id, $mcost, $dcost, $icost, $ecost, $tcost);

        foreach($Units AS $Unit)
        {
            if($request[$Unit->id] > 0)
            {
                $getData = $Unit->getData->where('race', uData('race'))->pluck('value', 'key');
                //auftrag Starten
                UserUnitsBuild::create([
                    'user_id' => auth()->user()->id,
                    'unit_id' => $Unit->id,
                    'value' => $request[$Unit->id],
                    'time' => time() + ( 180 * $getData['tech_build_time'] / 100 * session('ServerData')['Tech.Speed.Percent']->value),
                    'quantity' => ltrim($request[$Unit->id])
                ]);
            }
        }

        return back();

        dd($request,$mcost,$dcost,$icost,$ecost,$tcost);
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
