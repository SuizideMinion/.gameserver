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
                    <div class="card card-ext">
                        <img src="{{ getImage('_1.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="..." style="width: 50%">
                        <div class="card-body">
                            <h5 class="card-title" style="color: white;font-weight: bold">{{ Lang('global_ress1_name') }}</h5>
                            <p class="card-text">{{ Lang('global_ress1_desc') }}</p>
{{--                            <p class="card-text">Kollektor Ertrag: ({{ hasTech(1, 5, 2) ? 1:2 }}:1) <span></span></p>--}}
                            <p class="card-text">Planetarer Ertrag: <span>{{ hasTech(1, 16) ? 4000:1000 }}</span></p>
                            <p class="card-text">RessProTick: <span>{{ json_decode(uData('ressProTick'))->ress1 }}</span></p>
                            <div class="message-type-there">
                                <div class="search-bar">
                                    <i class="bi bi-percent"></i>
                                    <input type="number" placeholder="Percent" value="{{ $ressKey->ress1 }}" name="ress1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-ext">
                        <img src="{{ getImage('_2.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="..." style="width: 50%">
                        <div class="card-body">
                            <h5 class="card-title" style="color: white;font-weight: bold">{{ Lang('global_ress2_name') }}</h5>
                            <p class="card-text">{{ Lang('global_ress2_desc') }}</p>
{{--                            <p class="card-text">Kollektor Ertrag: ({{ hasTech(1, 6, 2) ? 2:4 }}:1) <span>10000</span></p>--}}
                            <p class="card-text">Planetarer Ertrag: <span>{{ hasTech(1, 16) ? 500:125 }}</span></p>
                            <p class="card-text">RessProTick: <span>{{ json_decode(uData('ressProTick'))->ress2 }}</span></p>
                            <div class="message-type-there">
                                <div class="search-bar">
                                    <i class="bi bi-percent"></i>
                                    <input type="number" placeholder="Percent" value="{{ $ressKey->ress2 }}" name="ress2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-ext">
                        <img src="{{ getImage('_3.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="..." style="width: 50%">
                        <div class="card-body">
                            <h5 class="card-title" style="color: white;font-weight: bold">{{ Lang('global_ress3_name') }}</h5>
                            <p class="card-text">{{ Lang('global_ress3_desc') }}</p>
{{--                            <p class="card-text">Kollektor Ertrag: ({{ hasTech(1, 7, 2) ? 3:6 }}:1) <span>10000</span></p>--}}
                            <p class="card-text">Planetarer Ertrag: <span>{{ hasTech(1, 16) ? 200:75 }}</span></p>
                            <p class="card-text">RessProTick: <span>{{ json_decode(uData('ressProTick'))->ress3 }}</span></p>
                            <div class="message-type-there">
                                <div class="search-bar">
                                    <i class="bi bi-percent"></i>
                                    <input type="number" placeholder="Percent" value="{{ $ressKey->ress3 }}" name="ress3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-ext">
                        <img src="{{ getImage('_4.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="..." style="width: 50%">
                        <div class="card-body">
                            <h5 class="card-title" style="color: white;font-weight: bold">{{ Lang('global_ress4_name') }}</h5>
                            <p class="card-text">{{ Lang('global_ress4_desc') }}</p>
{{--                            <p class="card-text">Kollektor Ertrag: ({{ hasTech(1, 8, 2) ? 4:8 }}:1) <span>{{--}}
{{--    uData('kollektoren') / 100 * json_decode(--}}
{{--        \App\Models\UserData::where('user_id', auth()->user()->id)->where('key', 'ress.verteilung')->first()->value)->ress1 }}</span></p>--}}
                            <p class="card-text">Planetarer Ertrag: <span>{{ hasTech(1, 16) ? 100:50 }}</span></p>
                            <p class="card-text">RessProTick: <span>{{ json_decode(uData('ressProTick'))->ress4 }}</span></p>
                            <div class="message-type-there">
                                <div class="search-bar">
                                    <i class="bi bi-percent"></i>
                                    <input type="number" placeholder="Percent" value="{{ $ressKey->ress4 }}" name="ress4">
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
@endsection

@section('scripts')

@endsection
