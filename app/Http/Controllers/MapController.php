<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $Planets = Planet::get();
        $Users = User::with('getData')->get();
//        dd($Users);
        // var_dump(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']);die;
        return view('map.index', compact('Planets', 'Users'));
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
        $Planet = Planet::with('getUser', 'getData', 'getUserData')->where('id', $id)->first();
        $UserData = $Planet->getUserData->pluck('value', 'key');
        $PlanetData = $Planet->getData->where('user_id', auth()->user()->id)->pluck('value', 'key');
//dd($Planet);
        $array = [
            'name' => $Planet->name,
            'y' => $Planet->y,
            'x' => $Planet->x,
            'size' => $Planet->size,
            'username' => ($Planet->getUser->name ?? false),
            'pname' => ($UserData['planet.name'] ?? false),
            'data' => json_encode($PlanetData)
        ];

//        dd($array);

        return json_encode($array);
//
//        if($id[0] == 'u')
//        {
//          $id = ltrim($id, 'u');
//          $UserSkill = \App\Models\UserSkill::where('id', auth()->user()->id)->first();
//          $Planet = \App\Models\User::where('id', $id)->first();
//          // $Users =
//          $PlanetOwner = '';
//          $Function = [
//            'FlightTime' => 'Spieler',
//            'canAttack' => '',
//            'Owner' => $PlanetOwner,
//            'x' => $Planet->posXmap,
//            'y' => $Planet->posYmap,
//            'Ress' => '',
//          ];
//          $array = array('UserSkill' => $UserSkill, 'Planet' => $Planet, 'Function' => $Function);
//          return response()->json($array);
//
//        }
//        $UserSkill = \App\Models\UserSkill::where('id', auth()->user()->id)->first();
//        $Planet = \App\Models\Planet::where('id', $id)->first();
//        // $Users = \App\Models\User::where('posXmap', '>', '0')->get();
//        if($Planet->owner > 0 ) $PlanetOwner = \App\Models\User::where('id', $Planet->owner)->first()->name;
//        else $PlanetOwner = '';
//        if( $Planet->R1 > 0 ) $Ress = round($Planet->R1 + (auth()->user()->businessPoints * getSetting('Planet.Ressurce.Multiplikator') )) .' '. __('R1');
//        if( $Planet->R2 > 0 ) $Ress = round($Planet->R2 + (auth()->user()->businessPoints * getSetting('Planet.Ressurce.Multiplikator') )) .' '. __('R2');
//        if( $Planet->R3 > 0 ) $Ress = round($Planet->R3 + (auth()->user()->businessPoints * getSetting('Planet.Ressurce.Multiplikator') )) .' '. __('R3');
//        if( $Planet->R4 > 0 ) $Ress = round($Planet->R4 + (auth()->user()->businessPoints * getSetting('Planet.Ressurce.Multiplikator') )) .' '. __('R4');
//        $Function = [
//          'FlightTime' => intervall($Planet->getFlightTime()),
//          'canAttack' => $Planet->canAttack(),
//          'Owner' => $PlanetOwner,
//          'x' => $Planet->x,
//          'y' => $Planet->y,
//          'Ress' => $Ress,
//        ];
//        $array = array('UserSkill' => $UserSkill, 'Planet' => $Planet, 'Function' => $Function);
//        return response()->json($array);
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
        $UserSkill = \App\Models\UserSkill::where('id', auth()->user()->id)->first();
        if ( $UserSkill->hp < 10 ) return \Redirect::back()->withErrors(['msg' => 'Repariere erstmal dein Schiff']);
        $Planet = \App\Models\Planet::where('id', $id)->first();
        if ( $UserSkill->skill_update != 0 ) return \Redirect::back()->withErrors(['msg' => 'A Skill is Running']);
        if ( $UserSkill->energy < $UserSkill->getEnergyDrain() ) return \Redirect::back()->withErrors(['msg' => 'Energy to Low']);

        $time = time() + $Planet->getFlightTime();
        date_default_timezone_set('Europe/Berlin');
        if ( $Planet->owner != 0 )
        {
          \App\Models\News::create([
            'user_id' => $Planet->owner,
            'typ' => 51,
            'time' => time(),
            'text' => __('news.attack', ['name' => auth()->user()->name, 'time' => date("d-m-Y H:i:s",$time)]),
            'seen' => 0,
          ]);
          addLogToUser(auth()->user()->id, 'Startet einen Angriff auf '.$Planet->hasOwner->name.'');
        } else {
          addLogToUser(auth()->user()->id, 'beginnt einen Planeten zu Besiedeln');
        }
        \App\Models\UserSkill::where('id', auth()->user()->id)->update([
          'lastSkill' => 9999,
          'skill_update' => 9999,
          'energy' => $UserSkill->energy - $UserSkill->getEnergyDrain(),
          'planet' => $id,
          'time' => $time
        ]);
        return redirect('/map?x='.$Planet->x.'&y='.$Planet->y);
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
