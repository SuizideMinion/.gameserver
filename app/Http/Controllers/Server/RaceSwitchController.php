<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;

class RaceSwitchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Server.race.index');
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
        if( isset( $request->name ) AND isset( $request->pname ) AND isset( $request->race ) )
        {
            function checkInput($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            $name = checkInput($request->name);
            $pname = checkInput($request->pname);

            $NameCheck = User::where('name', $name)->whereNot('id', auth()->user()->id)->first();

            if ($NameCheck) return back()->with('error', 'Name Schon Vergeben');

            $PlanetCheck = UserData::where('key', 'planet.name')->where('value', $pname)->whereNot('user_id', auth()->user()->id)->first();

            if ($PlanetCheck) return back()->with('error', 'Planetenname ist schon Vergeben!');

            User::where('id', auth()->user()->id)->update(['name' => $name]);

            UserData::updateOrCreate(
                [
                    'user_id' => auth()->user()->id,
                    'key' => 'planet.name'
                ],
                [
                    'value' => $pname
                ]
            );
            UserData::updateOrCreate(
                [
                    'user_id' => auth()->user()->id,
                    'key' => 'race'
                ],
                [
                    'value' => (int)$request->race
                ]
            );
            return redirect('/map');
        }
        else {
            return back()->with('error', 'Bitte alles ausf??llen!');
        }
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
