@extends('layout.local')

@section('styles')
    <style>
        body {
            overflow: hidden;
        }

        #zoom {
            width: 20000px;
            height: 10000px;
            transform-origin: 0px 0px;
            transform: scale(0.1) translate(-8500px, -3500px);
            cursor: grab;
            position: absolute;
        }

        .Planet {
            width: 2048px;
            height: 2048px;
            background-image: url("{{getImage('.png', path: 'planets', race: uData('race'))}}");
            background-repeat: no-repeat;
            background-size: cover;
            position: absolute;
            left: calc(50% - 1000px);
            top: calc(50% - 1000px);
        }

        .Moon {
            width: 800px;
            height: 800px;
            background-image: url("{{getImage('Moon.png', path: 'planets')}}");
            background-repeat: no-repeat;
            background-size: cover;
            position: absolute;
            left: calc(50% + 1500px);
            top: calc(50% - 2000px);
        }

        div#zoom > img {
            width: 100%;
            height: auto;
        }

        .geb {
            width: 200px;
            height: 150px;
            position: absolute;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .geb:hover {
            border-radius: 80px;
            box-shadow: white 0px 0px 32px;
        }

        #gebactive {
            border-radius: 80px;
            box-shadow: green 0px 0px 32px;
            color: green;
            font-size: 30px;
            text-align: center;
        }


        .modal-content {
            background-color: transparent !important;
        }

        .modal-body {
            /*width: 500px;*/
            height: 600px;
        }

        p {
            margin: 0px !important;
            margin-bottom: 0px !important;
            padding: 0px;
        }
        .span-icon {
            position: relative;
            top: 0px;
            left: 13px;
        }
        .span-icon i{
            font-size: 50px;
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
        .Shield {
            position: absolute;
            top: 4052px;
            left: 9022px;
            width: 1975px;
            height: 1975px;
            border-radius: 1000px;
            box-shadow: white 0px 0px 116px;
        }
        .ShieldB {
            box-shadow: purple 0px 0px 116px;
        }
        .dynamic {
            width: 8px;
            height: 6px;
            position: absolute;
            background-image: url("{{ getImage('kollie.gif', 'ressurcen') }}");
            background-size: contain;
        }
        #dyn {
            position: absolute;
            top: 4052px;
            left: 9022px;
            width: 1975px;
            height: 1975px;
        }
    </style>
@endsection

@section('content')
    <div style="align-items: center;position: fixed;top: calc(50% - 45px); right: 10px;">
        <div class="mt-1" style="border: white 1px solid;border-radius: 9px;height: 32px;align-items: center;display: flex;"
             id="{{ ($ResearchActive ? 'resactive':'') }}"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             data-bs-placement="bottom"
             data-bs-original-title="<em>{{Lang('global_planet_research_name')}}</em>">
            <img onclick="showDialog('/researchs/')" style="width: 30px" src="{{ getImage('icon3.png', 'ressurcen') }}">
            {!! $ResearchActive ? timerHTML('resactive', $ResearchActive->time - time()):'' !!}
        </div>
        <div class="mt-1" style="border: white 1px solid;border-radius: 9px;height: 32px;align-items: center;display: flex;"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             data-bs-placement="bottom"
             data-bs-original-title="<em>{{Lang('global_planet_ressurces_name')}}</em>">
            <img onclick="showDialog('/resources/')" style="width: 30px" src="{{ getImage('icon1.png', 'ressurcen') }}">
        </div>
        <div class="mt-1" style="border: white 1px solid;border-radius: 9px;height: 32px;align-items: center;display: flex;"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             data-bs-placement="bottom"
             data-bs-original-title="<em>{{Lang('global_planet_kollektoren_name')}}</em>">
            <img onclick="showDialog('/kollektoren/')" style="width: 30px"
                 src="{{ getImage('icon2.png', 'ressurcen') }}">
            {!! ($userUnitsBuilds != 0) ? timerHTML('colactive', (($userUnitsBuilds * 60) + ( ( round ( time() / 60 ) * 60 ) - time() ))):'' !!}
        </div>
        <div class="mt-1" style="border: white 1px solid;border-radius: 9px;height: 32px;align-items: center;display: flex;"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             data-bs-placement="bottom"
             data-bs-original-title="<em>{{Lang('global_planet_shield_name')}}</em>">
            <img onclick="showDialog('/buildings/22')" style="width: 30px"
                 src="{{ getImage('icon4.png', 'ressurcen') }}">
            {!! ($userUnitsBuilds != 0) ? timerHTML('colactive', (($userUnitsBuilds * 60) + ( ( round ( time() / 60 ) * 60 ) - time() ))):'' !!}
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
