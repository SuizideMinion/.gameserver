@extends('layout.ingame')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))

@section('content')

    @php

        \App\Models\Logs::create([
            'user_id' => auth()->user()->id,
            'link' => URL::current(),
            'previous' => url()->previous(),
            'time' => time(),
            'text' => (__('Server Error') ?? 0),
            'post' => (json_encode($_POST) ?? 0)
        ]);

    @endphp

    <div class="heading" style="margin-top: 100px">
        Sorry we heave Problems here
        Please send us a Bugreport
    </div>
@endsection
