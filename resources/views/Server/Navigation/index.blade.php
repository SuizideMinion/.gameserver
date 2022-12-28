@extends('layout.local')

@section('styles')
    <style>

        p {
            margin: 0px !important;
            margin-bottom: 0px !important;
            padding: 0px;
        }

        .menu_right {
            width: 100px;
            border: white 1px solid;
            border-radius: 9px;
            height: 32px;
            align-items: center;
            display: flex;
            justify-content: space-between;
        }
    </style>
@endsection

@section('content')
    <div class="ressMain">
        <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
             title="<b>{{ Lang('global_ress1_name') }}</b><br>{{number_format(uRess()->ress1, 0, '', '.') }} <br><br><em>{{ Lang('global_ress1_desc') }}</em>">
            <img src="{{ getImage('_1.png', 'ressurcen', uData('race')) }}">
            <p>{{ number_shorten( uRess()->ress1, 0) }}</p>
        </div>
        <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
             title="<b>{{ Lang('global_ress2_name') }}</b><br>{{ number_format(uRess()->ress2, 0, '', '.') }} <br><br><em>{{ Lang('global_ress2_desc') }}</em>">
            <img src="{{ getImage('_2.png', 'ressurcen', uData('race')) }}">
            <p>{{ number_shorten( uRess()->ress2, 0) }}</p>
        </div>
        <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
             title="<b>{{ Lang('global_ress3_name') }}</b><br>{{ number_format(uRess()->ress3, 0, '', '.') }} <br><br><em>{{ Lang('global_ress3_desc') }}</em>">
            <img src="{{ getImage('_3.png', 'ressurcen', uData('race')) }}">
            <p>{{ number_shorten( uRess()->ress3, 0) }}</p>
        </div>
        <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
             title="<b>{{ Lang('global_ress4_name') }}</b><br>{{ number_format(uRess()->ress4, 0, '', '.') }} <br><br><em>{{ Lang('global_ress4_desc') }}</em>">
            <img src="{{ getImage('_4.png', 'ressurcen', uData('race')) }}">
            <p>{{ number_shorten( uRess()->ress4, 0) }}</p>
        </div>
        <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
             title="<b>{{ Lang('global_ress5_name') }}</b><br>{{ number_format(uRess()->ress5, 0, '', '.') }} <br><br><em>{{ Lang('global_ress5_desc') }}</em>">
            <img src="{{ getImage('_5.png', 'ressurcen', uData('race')) }}">
            <p>{{ number_shorten( uRess()->ress5, 0) }}</p>
        </div>
    </div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div class="bottom_navi">

        @if(session()->has('error'))
            <div style="display: flex;bottom: 10px;left: 10px;position: fixed;z-index: 99">
                <div>
                    <div class="arrow_box"
                         style="max-width: 150px;color: white;text-align: -webkit-center;">{{ session()->get('error') }}</div>
                    <img src="/assets/img/berater/berater{{ rand(1,11) }}.png" style="width: 100px;margin-top: 20px"></div>
            </div>
        @endif

        <div class="race-footerl" style=""></div>
        <div class="race-footerr" style=""></div>

        <div class="Navigation">
            <div class="race-head" style="z-index: 1000"></div>
            <div class="race-icon race-icona" style="z-index: 1000"
                 onclick="window.location.href = '{{ route('buildings.index') }}';">
                <i class="bi bi-globe" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
                   title="<b>{{ Lang('global_planet_name') }}</b> <br><br><em>{{ Lang('global_planet_desc') }}</em>"></i>
            </div>
            <div class="race-icon race-iconb" style="z-index: 1000"
                 onclick="window.location.href = '{{ route('map.index') }}';">
                <i class="bi bi-stars" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
                   title="<b>{{ Lang('global_map_name') }}</b> <br><br><em>{{ Lang('global_map_desc') }}</em>"></i>
            </div>
            <div class="race-icon race-iconc" style="z-index: 1000"
                 onclick="window.location.href = '{{ route('units.index') }}';">
                <i class="bi bi-chevron-double-up" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
                   title="<b>{{ Lang('global_military_name') }}</b> <br><br><em>{{ Lang('global_military_desc') }}</em>"></i>
            </div>
            <div class="race-icon race-icond" style="z-index: 1000"
                 onclick="window.location.href = '{{ route('ranking.index') }}';">
                <i class="bi bi-ladder" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
                   title="<b>{{ Lang('global_ranking_name') }}</b> <br><br><em>{{ Lang('global_ranking_desc') }}</em>"></i>
            </div>
            {{--        <div class="race-icon race-icone" style="color: gray"><i class="bi bi-star-fill"></i></div>--}}
            {{--        <div class="race-icon race-iconf" style="color: gray"><i class="bi bi-star-fill"></i></div>--}}
        </div>
        <li class="nav-item dropdown pe-3"
            style="position: fixed;right: 10px;bottom: 4px;color: aliceblue;list-style: none;display: flex;">

            <a class="nav-link nav-icon" href="/bugs" style="margin-right: 10px">
                <i class="bi bi-bug"></i>
            </a><!-- End Bugs Icon -->

            <a class="nav-link nav-icon" href="/Race" style="margin-right: 10px">
                <i class="bi bi-bootstrap-reboot"></i>
            </a><!-- End Bugs Icon -->

            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false"
               style="margin-right: 10px">
                <i class="bi bi-chat-left-text"></i>
            </a><!-- End Messages Icon -->
            <ul class="dropdown-menu messages" style="background-color: black;width: 350px">
            </ul><!-- End Messages Dropdown Items -->


            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-gear"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li>
                    <a class="dropdown-item d-flex align-items-center" onclick="notify.authorize()">
                        <i class="bi bi-person"></i>
                        <span>Benarichtigungen bei Gebäude/Forschungen</span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center">
                        <i class="bi bi-person"></i>
                        <span>{{time()}}</span>
                    </a>
                    @yield('settings')
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center">
                        <i class="bi bi-person"></i>
                        <span>
                    @desktop
                        Desktop
                    @elsedesktop
                        Mobile
                    @enddesktop
                </span>
                    </a>
                </li>

            </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

        <li class="nav-item dropdown pe-3"
            style="position: fixed;left: 10px;bottom: 4px;color: aliceblue;list-style: none;display: flex;">

            <a class="nav-link nav-icon" href="/logout" style="margin-right: 10px">
                <i class="bi bi-door-open-fill"></i>
            </a><!-- End logout Icon -->
        </li><!-- End Profile Nav -->
    </div>
    <div style="align-items: center;position: fixed;top: calc(50% - 108px); right: 10px;">
        <div class="mt-1 menu_right"
             id="{{ ($BuildingActive ? 'bulactive':'') }}"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             data-bs-placement="bottom"
             data-bs-original-title="<em>{{Lang('global_planet_building_name')}}</em>">
            <img onclick="showDialog('/technologies/1')" style="width: 30px" src="{{ getImage('icon5.png', 'ressurcen') }}">
            {!! $BuildingActive ? timerHTML('bulactive', $BuildingActive->time - time()):'' !!}
        </div>
        <div class="mt-1 menu_right"
             id="{{ ($ResearchActive ? 'resactive':'') }}"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             data-bs-placement="bottom"
             data-bs-original-title="<em>{{Lang('global_planet_research_name')}}</em>">
            <img onclick="showDialog('/researchs/')" style="width: 30px" src="{{ getImage('icon3.png', 'ressurcen') }}">
            {!! $ResearchActive ? timerHTML('resactive', $ResearchActive->time - time()):'' !!}
        </div>
        <div class="mt-1 menu_right"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             data-bs-placement="bottom"
             data-bs-original-title="<em>{{Lang('global_planet_ressurces_name')}}</em>">
            <img onclick="showDialog('/resources/')" style="width: 30px" src="{{ getImage('icon1.png', 'ressurcen') }}">
        </div>
        <div class="mt-1 menu_right"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             data-bs-placement="bottom"
             data-bs-original-title="<em>{{Lang('global_planet_kollektoren_name')}}</em>">
            <img onclick="showDialog('/kollektoren/')" style="width: 30px"
                 src="{{ getImage('icon2.png', 'ressurcen') }}">
            {!! ($userUnitsBuilds != 0) ? timerHTML('colactive', (($userUnitsBuilds * 60) + ( ( round ( time() / 60 ) * 60 ) - time() ))):'' !!}
        </div>
        <div class="mt-1 menu_right"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             data-bs-placement="bottom"
             data-bs-original-title="<em>{{Lang('global_planet_shield_name')}}</em>">
            <img onclick="showDialog('/buildings/22')" style="width: 30px"
                 src="{{ getImage('icon4.png', 'ressurcen') }}">
{{--            {!! ($userUnitsBuilds != 0) ? timerHTML('colactive', (($userUnitsBuilds * 60) + ( ( round ( time() / 60 ) * 60 ) - time() ))):'' !!}--}}
        </div>
        <div class="mt-1 menu_right"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             data-bs-placement="bottom"
             data-bs-original-title="<em>{{Lang('global_planet_commander_name')}}</em>">
            <img onclick="showDialog('/skills')" style="width: 30px"
                 src="{{ getImage('g_23.PNG', 'ressurcen') }}">
            {!! $SkillActive ? timerHTML('resactive', $SkillActive->time - time()):'' !!}
        </div>
    </div>
@endsection


@section('scripts')

    <script>
        function showDialog(id) {
            let myModal = new bootstrap.Modal(document.getElementById('showDialog'), {
                keyboard: false
            })
            $(".modal-body").html(
                '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            $(document).ready(function () {
                $('.modal-body').load(id);
            })
            myModal.show()
        }

        function closeDialog() {
            let myModal = new bootstrap.Modal(document.getElementById('showDialog'), {
                keyboard: false
            })
            myModal.hide()
        }

        function uSetting(key, value) {
            $.ajax({
                url: "/api/uSettings/{{uData('token')}}/" + key + "/" + value,
                success: function (res) {
                    console.log(res);
                    location.reload();
                }
            });
        }
    </script>
@endsection
