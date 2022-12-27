@extends('layout.local')

@section('styles')
    <style>
        .container {
            padding-bottom: 140px;
        }

        .agenda-one {
            padding: 0px;
        }
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

        .getImage {
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
            left: -1px;
            margin-left: -20px;
        }

        .span-icon-show i {
            font-size: 20px;
        }

        .bi-check-all {
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

@section('settings')
    <a class="dropdown-item d-flex align-items-center"
       onclick="uSetting('show.all.Buildings', {{uData('show.all.Buildings') == 1 ? 0:1}})" style="cursor: pointer">
        <i class="bi bi-person"></i>
        <span>{{uData('show.all.Buildings') == 1 ? 'nur Baubare Gebäude anzeigen':'alle Gebäude Anzeigen'}}</span>
    </a>
@endsection

@section('content')
<div class="container">
    <div class="agenda">
        @foreach($Builds as $Build)
            <div class="agenda-one">
                <span class="time">
                    <img onclick="window.location.href = {{
                        ($Build['art'] == 1 ? '"/buildings/'. $Build['id'] .'/edit"':'"/researchs/'. $Build['id'] .'/edit"') }}"
                         class="getImage"
                         src="{{ getImage($Build['image']) }}"
                         style="max-height: 38px;"
                         data-bs-toggle="tooltip"
                         data-bs-html="true"
                         {{--                     {{ dd(canTech(2, 10, 1)) }}--}}
                         title="<em>{{ $Build['name'] . $Build['level'] }}</em><br>
                        <p>{{ Lang('global_ress1_name') }}: <span class='m'>{{ $Build['ress1'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress2_name') }}: <span class='d'>{{ $Build['ress2'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress3_name') }}: <span class='i'>{{ $Build['ress3'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress4_name') }}: <span class='e'>{{ $Build['ress4'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress5_name') }}: <span class='t'>{{ $Build['ress5'] ?? 0 }}</span></p>
                        <p>{{ Lang('Buildtime') }} {{ timeconversion(((int)$Build['build_time'] ?? 0 ) / 100 * session('ServerData')['Tech.Speed.Percent']->value) }}</p>
                        <b>{{ $Build['desc'] }}</b>
                        <br>">
                    <span class="span-icon-show">
                        @if( $Build['canBuild']['Gebaut'] == 'true' )
                            <i class="bi bi-check-all"></i>
{{--                            <i class="bi bi-check-all" title="{{ print_r($Build['canBuild']) }}"></i>--}}
                        @elseif( !$Build['canBuild']['errors'] )
                            <i class="bi bi-arrow-up-short"></i>
{{--                            <i class="bi bi-arrow-up-short" title="{{ print_r($Build['canBuild']) }}"></i>--}}
                        @else
                            <i class="bi bi-x"></i>
{{--                            <i class="bi bi-x" title="{{ print_r($Build['canBuild']) }}"></i>--}}
                        @endif
                    </span>
                </span>
                <ul>
                    <li>
                        <span
                            class="agenda-name">{{ Lang('planet.building.name', array: [':NAME' => Lang(($id == 1 ? 'Building':'Research') .'.name.'. $Build['id']), ':LEVEL' => (session('UserBuildings')[$Build['id']]->level ?? 0), ':MAX' => $Build['max_level'] ]) }}
{{--                            {{ dd($Build['canTechnik']) }}--}}
{{--                            {{ ($Build['canBuild']['errors'] == [] ? 'baubar':'') }}--}}
                        </span>
                    </li>
                    <li>
                        <span class="green">
                            @foreach($Build['hasBuilds'] as $has)
                                <img onclick="window.location.href = {{
                                    ($has['art'] == 1 ? '"/buildings/'. $has['id'] .'/edit"':'"/researchs/'. $has['id'] .'/edit"') }}"
                                     class="getImage"
                                     src="{{ getImage($has['image']) }}"
                                     style="max-height: 38px;"
                                     data-bs-toggle="tooltip"
                                     data-bs-html="true"
                                     {{--                     {{ dd(canTech(2, 10, 1)) }}--}}
                                     title="<em>{{ $has['name'] . $has['level'] }}</em><br>
                                    <p>{{ Lang('global_ress1_name') }}: <span class='m'>{{ $has['ress1'] ?? 0 }}</span></p>
                                    <p>{{ Lang('global_ress2_name') }}: <span class='d'>{{ $has['ress2'] ?? 0 }}</span></p>
                                    <p>{{ Lang('global_ress3_name') }}: <span class='i'>{{ $has['ress3'] ?? 0 }}</span></p>
                                    <p>{{ Lang('global_ress4_name') }}: <span class='e'>{{ $has['ress4'] ?? 0 }}</span></p>
                                    <p>{{ Lang('global_ress5_name') }}: <span class='t'>{{ $has['ress5'] ?? 0 }}</span></p>
                                    <p>{{ Lang('Buildtime') }} {{ timeconversion(((int)$has['build_time'] ?? 0 ) / 100 * session('ServerData')['Tech.Speed.Percent']->value) }}</p>
                                    <b>{{ $has['desc'] }}</b>
                                    <br>">
                                <span class="span-icon-show">
                                    @if( $has['canBuild']['Gebaut'] == 'true' )
                                        <i class="bi bi-check-all"></i>
                                    @elseif( !$has['canBuild']['errors'] )
                                        <i class="bi bi-arrow-up-short"></i>
                                    @else
                                        <i class="bi bi-x"></i>
{{--                                                                    <i class="bi bi-x" title="{{ print_r($has['canBuild']) }}"></i>--}}
                                    @endif
                                </span>
                            @endforeach
                        </span>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>

    <div class="navi"></div>
</div>
@endsection


@section('scripts')
    <script>
        $(document).ready(navigation());

        function navigation() {
            $.ajax({
                url: "/Navigation/",
                success: function (res) {
                    $('.navi').html(res);
                }
            });
        }
    </script>
@endsection
