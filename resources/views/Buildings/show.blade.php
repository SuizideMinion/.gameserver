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
            left: -13px;
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

@section('content')

    @foreach($array as $Building)
        @if ($Building['disable'] != 1)
            <div class="heading mt-1" id="{{$Building['id']}}">
                <h3>
                    {{ Lang('planet.building.name', array: [':NAME' => Lang('Building.name.'. $Building['id']), ':LEVEL' => (session('UserBuildings')[$Building['id']]->level ?? 0), ':MAX' => $Building['max_level'] ]) }}
                </h3>
                <p>
                    {{ Lang('global_ress1_name') }}: {{ $Building['ress1'] }}
                    {{ Lang('global_ress2_name') }}: {{ $Building['ress2'] }}
                    {{ Lang('global_ress3_name') }}: {{ $Building['ress3'] }}
                    {{ Lang('global_ress4_name') }}: {{ $Building['ress4'] }}
                    {{ Lang('global_ress5_name') }}: {{ $Building['ress5'] }}
                </p>
                <p class="mt-1"></p>
                <p>
                    <img onclick="window.location.href = {{
                        ($Building['art'] == 1 ? '"/buildings/'. $Building['id'] .'/edit"':'"/researchs/'. $Building['id'] .'/edit"') }}"
                         class="getImage"
                         src="{{ getImage($Building['image']) }}"
                         style="
                         @if( $Building['canBuild']['Ausgebaut'] == 'true' )
                             border: green 1px solid;box-shadow: green 1px 1px 10px;
                         @elseif( !isset($Building['canBuild']['error']) )
                             border: orange 1px solid;box-shadow: orange 1px 1px 10px;
                         @endif
                             "
                         data-bs-toggle="tooltip"
                         data-bs-html="true"
                         title="<em>{{ $Building['name'] . ($Building['level'] ) }}</em><br>
                        <p>{{ Lang('global_ress1_name') }}: <span class='m'>{{ $Building['ress1'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress2_name') }}: <span class='d'>{{ $Building['ress2'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress3_name') }}: <span class='i'>{{ $Building['ress3'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress4_name') }}: <span class='e'>{{ $Building['ress4'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress5_name') }}: <span class='t'>{{ $Building['ress5'] ?? 0 }}</span></p>
                        <p>{{ Lang('Buildtime') }} {{ timeconversion(((int)$Building['build_time'] ?? 0 ) / 100 * session('ServerData')['Tech.Speed.Percent']->value) }}</p>
                             <b>{{ $Building['desc'] }}</b>
                        <br>">
                    <span class="span-icon-show">
                        @if( $Building['canBuild']['Gebaut'] == 'true' )
                            <i class="bi bi-check-all"></i>
                            {{--                            <i class="bi bi-check-all" title="{{ print_r($Build['canBuild']) }}"></i>--}}
                        @elseif( !$Building['canBuild']['errors'] )
                            <i class="bi bi-arrow-up-short"></i>
                            {{--                            <i class="bi bi-arrow-up-short" title="{{ print_r($Build['canBuild']) }}"></i>--}}
                        @else
                            <i class="bi bi-x"></i>
                            {{--                            <i class="bi bi-x" title="{{ print_r($Build['canBuild']) }}"></i>--}}
                        @endif
                </span>
                    <i style="font-size: 20px;top: 4px;position: relative;left: -10px;"
                       class="bi bi-chevron-double-right"></i>
                    @foreach($Building['hasBuilds'] as $has)
                        <img onclick="window.location.href = {{
                                    ($has['art'] == 1 ? '"/buildings/'. $has['id'] .'/edit"':'"/researchs/'. $has['id'] .'/edit"') }}"
                             class="getImage"
                             src="{{ getImage($has['image']) }}"
                             style="max-height: 38px;"
                             data-bs-toggle="tooltip"
                             data-bs-html="true"
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
                </p>
                <span><i class="fa-solid fa-angle-down"></i></span>
            </div>
        @endif
    @endforeach
@endsection

@section('scripts')

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

@endsection
