@extends('layout.ingame')

@section('styles')
@endsection

@section('content')
    @include('layout/planet_navi')

    <div class="container" style="margin-top: 20px">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ getImage('_1.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ Lang('global_ress1_name') }}</h5>
                        <p class="card-text">{{ Lang('global_ress1_desc') }}</p>
                        <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ getImage('_2.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ Lang('global_ress2_name') }}</h5>
                        <p class="card-text">{{ Lang('global_ress2_desc') }}</p>
                        <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ getImage('_3.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ Lang('global_ress3_name') }}</h5>
                        <p class="card-text">{{ Lang('global_ress3_desc') }}</p>
                        <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ getImage('_4.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ Lang('global_ress4_name') }}</h5>
                        <p class="card-text">{{ Lang('global_ress4_desc') }}</p>
                        <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p>
        <button onclick="notify.authorize()" control-id="ControlID-1">Authorize</button>
        <button onclick="notify.show('text')" control-id="ControlID-2">Show</button>
        <button onclick="notify.showDelayed(5)" control-id="ControlID-3">Show&nbsp;in&nbsp;5s</button>
        <!-- TODO : add a button that shows a notification using a 'tag' -->
    </p>
    <textarea id="console" readonly="" control-id="ControlID-4">This is the output console.
Text will appear here when stuff happens.
------------------</textarea>
@endsection

@section('scripts')

@endsection
