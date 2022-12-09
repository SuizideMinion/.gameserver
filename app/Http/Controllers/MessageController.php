<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $Messages = Message::select('*')
            ->where(function ($query) use($id) {
                $query->where('sender_id','=',auth()->user()->id)
                    ->orWhere('sender_id','=', $id);
            })
            ->where(function ($query) use($id) {
                $query->where('retriever_id','=',auth()->user()->id)
                    ->orWhere('retriever_id','=', $id);
            })
            ->orderBy('created_at','asc')
            ->get();

        Message::where('retriever_id', auth()->user()->id)->where('sender_id', $id)->update([
            'read_retriever' => 1,
        ]);

        return view('messages.index', compact('Messages', 'id'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if($request->text != '')
        {
            Message::create([
                'text' => $request->text,
                'status' => 0,
                'sender_id' => auth()->user()->id,
                'retriever_id' => $id,
                'del_sender' => 0,
                'del_retriever' => 0,
                'read_sender' => 1,
                'read_retriever' => 0
            ]);

            return redirect()->back();
        } else {
            return redirect()->back()->withErrors('Bitte eine Nachricht Angeben');
        }
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

    public function JSON($token)
    {
        $uData = UserData::where('value', $token)->first();

        $Messages = Message::select('sender_id', 'text', 'users.name')
            ->where('retriever_id', $uData->user_id)
            ->where('read_retriever', 0)
            ->join('users', 'users.id', 'messages.sender_id')
            ->get();//->groupBy('sender_id');

        echo json_encode($Messages);
    }
}
