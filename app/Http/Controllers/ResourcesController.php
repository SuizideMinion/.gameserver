<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $userData = UserData::where('user_id', auth()->user()->id)->get()->pluck('value', 'key');
        $ressKey = json_decode($userData['ress.verteilung']);

        return view('resources.index', compact('userData', 'ressKey'));
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
        $ressCalc = $request->ress1 + $request->ress2 + $request->ress3 + $request->ress4;

        if ($request->ress1 > 0 AND !hasTech(1, 5, 1)) return back()->with('error', 'Multiplex gebäude Fehlt');
        if ($request->ress2 > 0 AND !hasTech(1, 6, 1)) return back()->with('error', 'D gebäude Fehlt');
        if ($request->ress3 > 0 AND !hasTech(1, 7, 1)) return back()->with('error', 'I gebäude Fehlt');
        if ($request->ress4 > 0 AND !hasTech(1, 8, 1)) return back()->with('error', 'E gebäude Fehlt');

        if( $request->ress1 >= 0 AND $request->ress2 >= 0 AND $request->ress3 >= 0 AND $request->ress4 >= 0) {
            if ($ressCalc == 100) {
                UserData::where('user_id', auth()->user()->id)->where('key', 'ress.verteilung')->update([
                    'value' => json_encode([
                        'ress1' => $request->ress1,
                        'ress2' => $request->ress2,
                        'ress3' => $request->ress3,
                        'ress4' => $request->ress4,
                    ])
                ]);
                ressCalc();
                return back();
            }
        }
        return back()->with('error', 'Alle 4 Ressurcen schlüssel zusammen müssen 100 Ergeben !');

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
