<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\Bugs;
use Illuminate\Http\Request;

class BugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $Bugs = Bugs::where('status', 1)->with('getUser')->orderBy('created_at', 'DESC')->get();
        $BugsB = Bugs::where('status', 2)->with('getUser')->orderBy('created_at', 'DESC')->get();
        $BugsF = Bugs::where('status', 3)->with('getUser')->orderBy('created_at', 'DESC')->get();

        $arrayGroups = [0, 1, 2, 3,4, 99];

        return view('Server.bugs.index', compact('Bugs', 'BugsB', 'BugsF', 'arrayGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrayGroups = [0, 1, 2, 3,4, 99];

        return view('Server.bugs.create', compact('arrayGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'text' => 'required',
        ]);

        Bugs::create([
            'title' => strip_tags($validated['title']),
            'text' => strip_tags($validated['text']),
            'group' => $request->group,
            'status' => 1,
            'user_id' => auth()->user()->id
        ]);

        return redirect('/bugs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $Bug = Bugs::where('id', $id)->first();

        return view('Server.bugs.show', compact('Bug'));
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
