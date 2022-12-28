<?php

namespace App\Http\Controllers\Commander;

use App\Http\Controllers\Controller;
use App\Models\Skills;
use App\Models\User;
use App\Models\UserSkills;
use Illuminate\Http\Request;

class UserSkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $UserSkills = UserSkills::where('user_id', auth()->user()->id)->get()->keyBy('skill_id');
        $UserSkillsActive = UserSkills::where('user_id', auth()->user()->id)->where('value', 1)->first();
        $Skills = Skills::get();
//dd();
        return view('commander.skills.index', compact('Skills', 'UserSkills', 'UserSkillsActive'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $UserSkills = UserSkills::where('user_id', auth()->user()->id)->where('value', 1)->first();
        if($UserSkills) return redirect()->back();

        $UserSkills = UserSkills::where('user_id', auth()->user()->id)->where('skill_id', $id)->first();

        UserSkills::updateOrCreate(
            [
                'user_id' => auth()->user()->id,
                'skill_id' => $id
            ],
            [
                'time' => time() + (getUserSkillTime($id)),
                'value' => 1,
                'level' => ($UserSkills->level ?? 0)
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
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
