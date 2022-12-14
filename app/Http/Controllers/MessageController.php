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
        $Messagess = Message::where('sender_id', auth()->user()->id);

        $Messages = Message::where('retriever_id', auth()->user()->id)
            ->union($Messagess)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('messages.index', compact('Messages'));
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

        return view('messages.show', compact('Messages', 'id'));
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
                'text' => strip_tags($request->text),
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
//
//        $Messages = Message::select('sender_id', 'text', 'users.name')
//            ->where('retriever_id', $uData->user_id)
//            ->where('read_retriever', 0)
//            ->join('users', 'users.id', 'messages.sender_id')
//            ->get();//->groupBy('sender_id');

        $Messagess = Message::where('sender_id', $uData->user_id)->with('getUserR');

        $Messages = Message::where('retriever_id', $uData->user_id)
            ->with('getUserS')
            ->union($Messagess)
            ->orderBy('created_at', 'DESC')
            ->get();

        $NewMessage = Message::where('retriever_id', $uData->user_id)
            ->where('read_retriever', 0)
            ->first();

        $ids = [];

        foreach( $Messages AS $Message)
        {
            if (!isset($ids['s'. ($Message->retriever_id != $uData->user_id ? $Message->retriever_id : $Message->sender_id)])) {
                $ids['s'. ($Message->retriever_id != $uData->user_id ? $Message->retriever_id : $Message->sender_id)] =
                    [
                        'text' => $Message->text,
                        'id' => ($Message->retriever_id != $uData->user_id ? $Message->retriever_id : $Message->sender_id),
                        'name' => 'huhu',
                        'read' => ($Message->retriever_id == $uData->user_id ? $Message->read_retriever : $Message->read_sender),
                        'new' => ( isset($NewMessage->text) ? 'ja':'nein')
                    ];
            }
        }

        echo json_encode($ids);
    }
}
