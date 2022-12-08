<?php

namespace App\Http\Controllers;

use App\Models\Units;
use App\Models\UnitsData;
use App\Models\UserData;
use App\Models\UserUnits;
use App\Models\UserUnitsBuild;
use Illuminate\Http\Request;

class KollektorenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $userData = UserData::where('user_id', auth()->user()->id)->first()->pluck('value', 'key');
        $userUnitsBuilds = UserUnitsBuild::where('user_id', auth()->user()->id)->where('unit_id', 1)->get();
        $kollisImBau = \App\Models\UserUnitsBuild::where('unit_id', 1)->where('user_id', auth()->user()->id)->sum('quantity');

        return view('kollektoren.index', compact('userData', 'userUnitsBuilds', 'kollisImBau'));
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
        $UnitData = UnitsData::where('unit_id', 1)->where('race', uData('race'))->get()->keyBy('key');
        $colanz = uData('kollektoren') + UserUnitsBuild::where('unit_id', 1)->where('user_id', auth()->user()->id)->sum('quantity');
        $baukostenreduzierung = 0;
        $restyp01 = JSONuData('ress')->ress1;
        $restyp02 = JSONuData('ress')->ress2;
        $z = 0;

        for ($i = 1; $i <= $request->b_col; $i++) {

            if (floor(
                (1000 + floor($colanz * $colanz / 20 * 150)) * (1 - $baukostenreduzierung)) <= $restyp01 &&
                floor((100 + floor($colanz * $colanz / 20 * 20)) * (1 - $baukostenreduzierung)) <= $restyp02) {
                $restyp01 = $restyp01 - floor((1000 + ($colanz * $colanz / 20 * 150)) * (1 - $baukostenreduzierung));
                $restyp02 = $restyp02 - floor((100 + ($colanz * $colanz / 20 * 20)) * (1 - $baukostenreduzierung));
                $colanz++;
                $z++;
            } else break;
        }
//        dd($UnitData['tech_build_time']->value, $restyp01, $restyp02, $colanz, $z);
        if ( $z > 0 )
        {
            UserUnitsBuild::create([
                'user_id' => auth()->user()->id,
                'unit_id' => 1,
                'value' => 1,
                'quantity' => $z,
                'time' => time()
            ]);

            ressChance(auth()->user()->id, $restyp01, $restyp02);
        }
        return redirect()->back();
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
