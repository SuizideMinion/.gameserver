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

@section('settings')
    <a class="dropdown-item d-flex align-items-center"
       onclick="uSetting('show.all.Buildings', {{uData('show.all.Buildings') == 1 ? 0:1}})" style="cursor: pointer">
        <i class="bi bi-person"></i>
        <span>{{uData('show.all.Buildings') == 1 ? 'nur Baubare Gebäude anzeigen':'alle Gebäude Anzeigen'}}</span>
    </a>
@endsection

@section('content')
    <div id="zoom">
        <div class="Planet"></div>
        <div class="Moon"></div>
        <div id="dyn"></div>
        <div class=" {{ hasTech(1, 22, 2) ? 'Shield ShieldB': (hasTech(1, 22, 1) ? 'Shield': '')}}"></div>
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
        function createCircleOfDivs(num, radius, offsetX, offsetY, className) {
            var x, y;
            for (var n = 0; n < num; n++) {
                x = radius * Math.cos(n / num * 2 * Math.PI);
                y = radius * Math.sin(n / num * 2 * Math.PI);
                // let dyn = document.getElementById("dyn");
                let div = document.createElement("div");
                div.className = className;
                div.style.left = (x + offsetX) + "px";
                div.style.top = (y + offsetY) + "px";
                document.getElementById("dyn").append(div)
                // document.body.appendChild(div);
            }
        }
        createCircleOfDivs({{ uData('kollektoren') }}, 1400, 1000, 1000, "dynamic");
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
        let height = window.innerHeight;
        let scale = 0.1,
            panning = false,

            pointX = (0 - (1000 + width / 2 - width)),
            pointY = ( 0 - height / 8 ),
            start = {x: 0, y: 0},
            zoom = document.getElementById("zoom");

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

@endsection
