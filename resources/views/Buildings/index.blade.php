@extends('layout.ingame')

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
    <div id="zoom">
        {{--            Planetrarer Schild: --}}
        {{--                top: 4052px;--}}
        {{--                left: 9022px;--}}
        {{--                width: 1975px;--}}
        {{--                height: 1975px;--}}
        {{--                border-radius: 1000px;--}}
        {{--                box-shadow: white 0px 0px 116px;--}}
        <div class="Planet"></div>
        <div class="Moon"></div>
        @foreach($Builds as $Build)
            {{--            {{ ( hasTech(1, $Build['id']) ? 'style': canTech(1, $Build['id'])) }}--}}
            @if( hasTech(1, $Build['id']) OR canTech(1, $Build['id'], (session('UserBuildings')[$Build['id']]->level ?? 0) + 1))
                <div id="{{ (($BuildingActive->build_id ?? 0) == $Build['id'] ? 'gebactive':'') }}" class="geb geb1"
                     onclick="showDialog('/buildings/{{ $Build['id'] }}')"
                     style="
                         top: {{ $Build['kordX'] }}px;
                         left: {{ $Build['kordY'] }}px;
                         background-image: url('{{ getImage($Build['image'], 'technologies') }}')
                         "
                >
                    {!! ($BuildingActive->build_id ?? 0) == $Build['id'] ? timerHTML('buildactive', $BuildingActive->time - time()):'' !!}
                    <span class="span-icon">
                    <i class="bi {{
                        hasTech(1, $Build['id'], (session('UserBuildings')[$Build['id']]->level ?? 1)) == true ?
                        'bi-check-all': (canTech(1, $Build['id'], (session('UserBuildings')[$Build['id']]->level ?? 1)) == true ?
                        'bi-arrow-up-short':'bi-x') }}">
                    </i>
                </span>
                </div>
            @endif
        @endforeach
    <!-- Button trigger modal -->
        {{--                <div class="geb geb16" style="top: 4376px;left: 9742px;"></div>--}}
        {{--                <div class="geb geb17" style="top: 4872px;left: 10160px;"></div>--}}
        {{--                <div class="geb geb18" style="top: 5477px;left: 9498px;"></div>--}}
        {{--                <div class="geb geb19" style="top: 5449px;left: 10254px;"></div>--}}
        {{--                <div class="geb geb20" style="top: 5058px;left: 10318px;"></div>--}}
        {{--                <div class="geb geb21" style="top: 5126px;left: 10751px;"></div>--}}
        {{--                <div class="geb geb22" style="top: 4717px;left: 10273px;"></div>--}}
        {{--                <div class="geb geb23" style="top: 4211px;left: 10307px;"></div>--}}
        {{--                <div class="geb geb24" style="top: 5346px;left: 10361px;"></div>--}}
        {{--                <div class="geb geb25" style="top: 4612px;left: 10772px;"></div>--}}
    </div>
    <!-- Modal -->
    <div class="modal  modal-xl" id="showDialog" data-bs-keyboard="false" tabindex="-1" aria-labelledby="showDialog"
         aria-hidden="true">
        <button style="color: red;font-size: xx-large;position: fixed;right: 20px;top: 20px;" type="button"
                class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-circle" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
               aria-label="close"></i>
        </button>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    ...
                </div>
                {{--                <button type="button" class="btn-close" onclick="closeDialog()" style="position: absolute;right: 10px;top: 10px;"></button>--}}
            </div>
        </div>
    </div>
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
    <script>
        $('.m').each(function () {
            if ($(this).text() > {{ uRess()->ress1 }}) {
                $(this).css("color", "red");
            }
        });
        $('.d').each(function () {
            if ($(this).text() > {{ uRess()->ress2 }}) {
                $(this).css("color", "red");
            }
        });
        $('.i').each(function () {
            if ($(this).text() > {{ uRess()->ress3 }}) {
                $(this).css("color", "red");
            }
        });
        $('.e').each(function () {
            if ($(this).text() > {{ uRess()->ress4 }}) {
                $(this).css("color", "red");
            }
        });
        $('.t').each(function () {
            if ($(this).text() > {{ uRess()->ress5 }}) {
                $(this).css("color", "red");
            }
        });
    </script>

    <script>
        let width = window.innerWidth;
        let scale = 0.1,
            panning = false,

            pointX = (0 - (1000 + width / 2 - width)),
            pointY = 0,
            start = {x: 0, y: 0},
            zoom = document.getElementById("zoom");

        setTransform();

        function setTransform() {
            zoom.style.transform = "translate(" + pointX + "px, " + pointY + "px) scale(" + scale + ")";
        }

        zoom.onmousedown = function (e) {
            e.preventDefault();
            start = {x: e.clientX - pointX, y: e.clientY - pointY};
            panning = true;
        }

        zoom.onmouseup = function (e) {
            panning = false;
        }

        zoom.onmousemove = function (e) {
            e.preventDefault();
            if (!panning) {
                return;
            }
            pointX = (e.clientX - start.x);
            pointY = (e.clientY - start.y);
            setTransform();
        }

        const debounce = function(func, delay){
            let timer;
            return function () {     //anonymous function
                const context = this;
                const args = arguments;
                clearTimeout(timer);
                timer = setTimeout(()=> {
                    func.apply(context, args)
                },delay);
            }
        }

        zoom.onwheel = debounce(function (e) {
            // console.info('Hey! It is', e);
            // e.preventDefault();
            let xs = (e.clientX - pointX) / scale,
                ys = (e.clientY - pointY) / scale,
                delta = (e.wheelDelta ? e.wheelDelta : -e.deltaY);
            if (delta < 0 && scale > 0.2 || delta > 0) {
                (delta > 0) ? (scale *= 1.2) : (scale /= 1.2);
                pointX = e.clientX - xs * scale;
                pointY = e.clientY - ys * scale;
                setTransform();
            }
        }, 10);

        zoom.ontouchstart = function (e) {
            e.preventDefault();
            start = {x: e.clientX - pointX, y: e.clientY - pointY};
            panning = true;
        }

        zoom.ontouchend = function (e) {
            panning = false;
        }

        zoom.ontouchmove = function (e) {
            e.preventDefault();
            if (!panning) {
                return;
            }
            pointX = (e.clientX - start.x);
            pointY = (e.clientY - start.y);
            setTransform();
        }

        setTransform();
    </script>

    @isset($BuildingActive->time)
        <script>
            function getTimeRemaining(endtime) {
                let total = Date.parse(endtime) - Date.parse(new Date());
                let seconds = Math.floor((total / 1000) % 60);
                let minutes = Math.floor((total / 1000 / 60) % 60);
                let hours = Math.floor((total / (1000 * 60 * 60)) % 24);
                let days = Math.floor(total / (1000 * 60 * 60 * 24));

                return {
                    total,
                    days,
                    hours,
                    minutes,
                    seconds
                };
            }

            function initializeClock(id, endtime) {
                let clock = document.getElementById(id);
                let Timer = clock.querySelector('.Timer');

                function updateClock() {
                    let t = getTimeRemaining(endtime);

                    Timer.innerHTML = (t.days !== 0 ? t.days + 'Tage ' : '') + ('0' + t.hours).slice(-2) + ':' + ('0' + t.minutes).slice(-2) + ':' + ('0' + t.seconds).slice(-2);

                    if (t.total <= 0) {
                        clearInterval(timeinterval);
                        Timer.innerHTML = 'Fertig!';
                        // window.location.reload();
                    }
                }

                updateClock();
                let timeinterval = setInterval(updateClock, 1000);
            }

            initializeClock('gebactive', new Date({{$BuildingActive->time * 1000}}));
        </script>
    @endisset
@endsection
