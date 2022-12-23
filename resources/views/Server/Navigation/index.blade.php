@extends('layout.local')

@section('styles')
    <style>

        p {
            margin: 0px !important;
            margin-bottom: 0px !important;
            padding: 0px;
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
