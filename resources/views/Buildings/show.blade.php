@extends('layout.local')

@section('styles')
    <style type="text/css">
        img {
            max-width: 100%;
        }

        .recent_heading h4 {
            color: #05728f;
            font-size: 21px;
            margin: auto;
        }

        .srch_bar input {
            border: 1px solid #cdcdcd;
            border-width: 0 0 1px 0;
            width: 80%;
            padding: 2px 0 4px 6px;
            background: none;
        }

        .srch_bar .input-group-addon button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            padding: 0;
            color: #707070;
            font-size: 18px;
        }

        .chat_ib h5 {
            font-size: 15px;
            color: #464646;
            margin: 0 0 8px 0;
        }

        .chat_ib h5 span {
            font-size: 13px;
            float: right;
        }

        .chat_ib p {
            font-size: 14px;
            color: #989898;
            margin: auto
        }

        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .sent_msg p {
            background: #05728f none repeat scroll 0 0;
            border-radius: 3px;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }
        .getImage{
            max-width: 100%;
            width: 50px;
            border-radius: 13px;
        }

        p {
            margin: 0px;
        }
        .span-icon-show {
            position: relative;
            top: 0px;
            left: -13px;
        }
        .span-icon-show i{
            font-size: 20px;
        }
        .bi-check-all{
            color: green;
        }
        .bi-arrow-up-short {
            color: orange;
        }
        .bi-x {
            color: red;
        }
    </style>
@endsection

@section('content')

    @foreach($array as $Research)
        @if ($Research['disable'] != 1)
            <div class="heading mt-1" id="{{$Research['id']}}">
                <h3>
                    {{ $Research['name'] }}
                </h3>
                <p>
                    {{ Lang('global_ress1_name') }}: {{ $Research['ress1'] }}
                    {{ Lang('global_ress2_name') }}: {{ $Research['ress2'] }}
                    {{ Lang('global_ress3_name') }}: {{ $Research['ress3'] }}
                    {{ Lang('global_ress4_name') }}: {{ $Research['ress4'] }}
                    {{ Lang('global_ress5_name') }}: {{ $Research['ress5'] }}
                </p>
                <p class="mt-1"></p>
                <p>
                    <img onclick="{{
                    ($Research['art'] == 1 ? 'window.location.href = "/buildings/'. $Research['id'] .'/edit"':
                    (!canTech($Research['art'], $Research['id'], $Research['level']) ?
                    'showResearch("/researchs/'. $Research['group'] .'#'. $Research['id'].'");' :
                    'window.location.href = "/researchs/'. $Research['id'] .'/edit"') ) }}"
                         class="getImage"
                         src="{{ getImage($Research['image']) }}"
                         style="{{ hasTech($Research['art'], $Research['id'], $Research['level']) == true ? 'border: green 1px solid;box-shadow: green 1px 1px 10px;': (canTech($Research['art'], $Research['id'], $Research['level']) == true ? 'border: orange 1px solid;box-shadow: orange 1px 1px 10px;':'') }}"
                         data-bs-toggle="tooltip"
                         data-bs-html="true"
                         {{--                     {{ dd(canTech(2, 10, 1)) }}--}}
                         title="<em>{{ $Research['name'] . $Research['level'] }}</em><br>
                        <p>{{ Lang('global_ress1_name') }}: <span class='m'>{{ $Research['ress1'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress2_name') }}: <span class='d'>{{ $Research['ress2'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress3_name') }}: <span class='i'>{{ $Research['ress3'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress4_name') }}: <span class='e'>{{ $Research['ress4'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress5_name') }}: <span class='t'>{{ $Research['ress5'] ?? 0 }}</span></p>
{{--                        <p>{{ Lang('Buildtime') }} {{ timeconversion(($has['build_time'] ?? 0 ) / 100 * session('ServerData')['Tech.Speed.Percent']->value) }}</p>--}}
                             <b>{{ $Research['desc'] }}</b>
                        <br>">
                    <span class="span-icon-show">
                    <i class="bi {{
                        hasTech($Research['art'], $Research['id'], $Research['level']) == true ?
                        'bi-check-all': (canTech($Research['art'], $Research['id'], $Research['level']) == true ?
                        'bi-arrow-up-short':'bi-x') }}">
                    </i>
                </span>
                    <i style="font-size: 20px;top: 4px;position: relative;left: -10px;" class="bi bi-chevron-double-right"></i>
                    @foreach($Research['hasBuilds'] as $has)
                        <img onclick="{{
                    ($has['art'] == 1 ? 'window.location.href = "/buildings/'. $has['id'] .'/edit"':
                    (!canTech($has['art'], $has['id'], $has['level']) ?
                    'showResearch("/researchs/'. $has['group'] .'#'. $has['id'].'");' :
                    'window.location.href = "/researchs/'. $has['id'] .'/edit"') ) }}"
                             class="getImage"
                             src="{{ getImage($has['image']) }}"
                             style="{{ hasTech($has['art'], $has['id'], $has['level']) == true ? 'border: green 1px solid;box-shadow: green 1px 1px 10px;': (canTech($has['art'], $has['id'], $has['level']) == true ? 'border: orange 1px solid;box-shadow: orange 1px 1px 10px;':'') }}"
                             data-bs-toggle="tooltip"
                             data-bs-html="true"
                             {{--                     {{ dd(canTech(2, 10, 1)) }}--}}
                             title="<em>{{ $has['name'] . $has['level'] }}</em><br>
                        <p>{{ Lang('global_ress1_name') }}: <span class='m'>{{ $has['ress1'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress2_name') }}: <span class='d'>{{ $has['ress2'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress3_name') }}: <span class='i'>{{ $has['ress3'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress4_name') }}: <span class='e'>{{ $has['ress4'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress5_name') }}: <span class='t'>{{ $has['ress5'] ?? 0 }}</span></p>
{{--                        <p>{{ Lang('Buildtime') }} {{ timeconversion(($has['build_time'] ?? 0 ) / 100 * session('ServerData')['Tech.Speed.Percent']->value) }}</p>--}}
                                 <b>{{ $has['desc'] }}</b>
                        <br>">
                        <span class="span-icon-show">
                    <i class="bi {{
                        hasTech($has['art'], $has['id'], $has['level']) == true ?
                        'bi-check-all': (canTech($has['art'], $has['id'], $has['level']) == true ?
                        'bi-arrow-up-short':'bi-x') }}">
                    </i>
                </span>
                    @endforeach
                </p>
                <span><i class="fa-solid fa-angle-down"></i></span>
            </div>
        @endif
    @endforeach
{{--<div class="carousel__cell"--}}
{{--     onclick="window.location.href = '{{ route('buildings.edit', $Building->id) }}';"--}}
{{--     style="--}}
{{--         background-image:--}}
{{--         linear-gradient(rgba(0, 0, 0, 0.5),--}}
{{--         rgba(0, 0, 0, 0.5)),--}}
{{--         url('/assets/img/technologies/{{ $Building->pluck()['1.image'] }}');--}}
{{--         background-repeat: no-repeat;--}}
{{--         background-size: contain;--}}
{{--         width: 100%;--}}
{{--         ">--}}
{{--    <br>--}}
{{--    <h2 class="" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"--}}
{{--        title="<em>{{ Lang('Building.desc.'. $Building->id) }}</em>">--}}
{{--        {{ Lang('planet.building.name', array: [':NAME' => Lang('Building.name.'. $Building->id), ':LEVEL' => (session('UserBuildings')[$Building->id]->level ?? 0), ':MAX' => $Building->pluck()['1.max_level'] ]) }}--}}
{{--    </h2><br>--}}
{{--    @if( !hasTech(1, $Building->id, (session('Buildings')[$Building->id]->getData->pluck('value', 'key')['1.max_level'])) )--}}
{{--        <p class=""--}}
{{--           style="">{{ Lang('planet.building.build', [':level' => (session('UserBuildings')[$Building->id]->level ?? 0) + 1], plural: (session('UserBuildings')[$Building->id]->level ?? 0) + 1) }}</p>--}}
{{--        <p class="m-0">{{ Lang('global_ress1_name') }}:--}}
{{--            <span--}}
{{--                class="m">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress1'] ?? 0 }}</span>--}}
{{--        </p>--}}
{{--        <p class="m-0">{{ Lang('global_ress2_name') }}:--}}
{{--            <span--}}
{{--                class="d">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress2'] ?? 0 }}</span>--}}
{{--        </p>--}}
{{--        <p class="m-0">{{ Lang('global_ress3_name') }}:--}}
{{--            <span--}}
{{--                class="i">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress3'] ?? 0 }}</span>--}}
{{--        </p>--}}
{{--        <p class="m-0">{{ Lang('global_ress4_name') }}:--}}
{{--            <span--}}
{{--                class="e">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress4'] ?? 0 }}</span>--}}
{{--        </p>--}}
{{--        <p class="m-0">{{ Lang('global_ress5_name') }}:--}}
{{--            <span--}}
{{--                class="t">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress5'] ?? 0 }}</span>--}}
{{--        </p>--}}
{{--        <p class="m-0">{{ Lang('Buildtime') }}--}}
{{--            : {{ timeconversion($Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.tech_build_time'] / 100 * session('ServerData')['Tech.Speed.Percent']->value) }}</p>--}}
{{--        <br>--}}
{{--        <br>--}}
{{--        @if($BuildingActive)--}}
{{--            @if($BuildingActive->build_id == $Building->id)--}}
{{--                {{ Lang('planet.building.active') }}--}}
{{--                @set($timeend, session('UserBuildings')[$Building->id]->time - time())--}}
{{--                <div id="clockdiv">--}}
{{--                    <span class="Timer"></span>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        @else--}}
{{--            @if(canTech(1, $Building->id, (session('UserBuildings')[$Building->id]->level ?? 0) + 1))--}}
{{--                <a href="{{ route('buildings.edit', $Building->id) }}" class="orbit-btn">--}}
{{--                    {{ Lang('planet.buildings.Button.Build', plural: (((session('UserBuildings')[$Building->id]->level ?? 0) + 1))) }}--}}
{{--                </a>--}}
{{--            @endif--}}
{{--        @endif--}}
{{--    @else--}}
{{--        <p>{{ Lang('planet.building.completed') }}</p>--}}
{{--    @endif--}}
{{--</div>--}}

@endsection

@section('scripts')

    <script>
    </script>

@endsection
