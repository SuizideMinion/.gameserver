@extends('layout.ingame')

@section('styles')
@endsection

@section('content')
    @include('layout/planet_navi')

    <div class="container" style="margin-top: 20px">
        <div class="row">
            <form class="row g-3" method="post" action="{{ route('resources.store') }}">
                @csrf
                <div class="col-md-3">
                    <div class="card" style="background-color: transparent;color: white;">
                        <img src="{{ getImage('_1.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title" style="color: white;font-weight: bold">{{ Lang('global_ress1_name') }}</h5>
                            <p class="card-text">{{ Lang('global_ress1_desc') }}</p>
                            <div class="message-type-one">
                                <div class="text-btn" style="color: white">
                                    <input type="number" placeholder="Percent" value="{{ $ressKey->ress1 }}">
{{--                                    <button type="submit">send</button>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="background-color: transparent;color: white;">
                        <img src="{{ getImage('_2.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title" style="color: white;font-weight: bold">{{ Lang('global_ress2_name') }}</h5>
                            <p class="card-text">{{ Lang('global_ress2_desc') }}</p>
                            <div class="message-type-one">
                                <div class="text-btn" style="color: white">
                                    <input type="number" placeholder="Percent" value="{{ $ressKey->ress2 }}">
                                    {{--                                    <button type="submit">send</button>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="background-color: transparent;color: white;">
                        <img src="{{ getImage('_3.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title" style="color: white;font-weight: bold">{{ Lang('global_ress3_name') }}</h5>
                            <p class="card-text">{{ Lang('global_ress3_desc') }}</p>
                            <div class="message-type-one">
                                <div class="text-btn" style="color: white">
                                    <input type="number" placeholder="Percent" value="{{ $ressKey->ress3 }}">
                                    {{--                                    <button type="submit">send</button>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="background-color: transparent;color: white;">
                        <img src="{{ getImage('_4.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title" style="color: white;font-weight: bold">{{ Lang('global_ress4_name') }}</h5>
                            <p class="card-text">{{ Lang('global_ress4_desc') }}</p>
                            <div class="message-type-one">
                                <div class="text-btn" style="color: white">
                                    <input type="number" placeholder="Percent" value="{{ $ressKey->ress4 }}">
                                    {{--                                    <button type="submit">send</button>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: none">
                    <button type="submit"></button>
                </div>
            </form>
        </div>
    </div>
    @desktop
    Desktop
    @elsedesktop
    Mobile
    @enddesktop
@endsection

@section('scripts')

@endsection
