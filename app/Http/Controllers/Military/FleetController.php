<?php

namespace App\Http\Controllers\Military;

use App\Http\Controllers\Controller;
use App\Models\Units;
use App\Models\UserData;
use App\Models\UserUnits;
use App\Models\UserUnitsBuild;
use Illuminate\Http\Request;

class FleetController extends Controller
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
        $userUnits = UserUnits::where('fleet', 0)->where('user_id', auth()->user()->id)->get()->pluck('value', 'unit_id');
        $Units = Units::where('type', 2)->where('disable', 0)->with('getData')->get();

        return view('Military.Fleet.index', compact('Units', 'userData', 'userUnitsBuilds', 'userUnits'));
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
