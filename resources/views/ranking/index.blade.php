@extends('layout.ingame')
@set($c, 1)
@section('content')
    <div class="container">
    @foreach($Users AS $User)
            <div class="agenda" style="margin-top: 0px">
                <div class="agenda-one">
                    <span class="time">#{{ ( $c++ ) }}</span>
                    <ul>
                        <li>
                            <span class="agenda-name"><a
                                    href="{{ route('messages.show', $User->id) }}"> {{ $User->getData->pluck('value', 'key')['planet.name'] }} </a></span>
                        </li>
                        <li>
                            <span class="green">{{ $User->kollektoren }}</span>
                        </li>
                    </ul>
                </div>
            </div>
    @endforeach
    </div>
@endsection

@section('Scripts')
@endsection
