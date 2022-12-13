@extends('layout.ingame')

@section('styles')
    <style>
        body {
            height: 100vh;
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
            position: absolute;
            left: calc(50% - 1000px);
            top: calc(50% - 1000px);
        }
        div#zoom > img {
            width: 100%;
            height: auto;
        }

        .geb {
            width: 100px;
            height: 100px;
            position: absolute;
            background-color: aliceblue;
        }
    </style>
@endsection

@section('settings')
    <a class="dropdown-item d-flex align-items-center" onclick="uSetting('show.all.Buildings', {{uData('show.all.Buildings') == 1 ? 0:1}})" style="cursor: pointer">
        <i class="bi bi-person"></i>
        <span>{{uData('show.all.Buildings') == 1 ? 'nur Baubare Gebäude anzeigen':'alle Gebäude Anzeigen'}}</span>
    </a>
@endsection

@section('content')
    @include('layout/planet_navi')
    @set($c, 0)

        <div id="zoom">
            @foreach($Buildings as $key => $Building)
                @if($Building->can()['notDisplay'] == 0 OR uData('show.all.Buildings') == '1')
                    {{ $Building->desc }}
                @endif
            @endforeach
            <div class="Planet"></div>
                <div class="geb geb1" style="top: 5000px;left: 9200px;"></div>
                <div class="geb geb2" style="top: 4389px;left: 9260px;"></div>
                <div class="geb geb3" style="top: 4082px;left: 9770px;"></div>
                <div class="geb geb4" style="top: 4855px;left: 10868px;"></div>
                <div class="geb geb5" style="top: 4768px;left: 10589px;"></div>
                <div class="geb geb6" style="top: 4950px;left: 9828px;"></div>
                <div class="geb geb7" style="top: 4549px;left: 10097px;"></div>
                <div class="geb geb8" style="top: 4637px;left: 9553px;"></div>
                <div class="geb geb9" style="top: 5861px;left: 10063px;"></div>
                <div class="geb geb10" style="top: 5271px;left: 10504px;"></div>
                <div class="geb geb11" style="top: 5619px;left: 10603px;"></div>
                <div class="geb geb12" style="top: 5157px;left: 9626px;"></div>
                <div class="geb geb13" style="top: 5334px;left: 9134px;"></div>
                <div class="geb geb14" style="top: 5334px;left: 9842px;"></div>
                <div class="geb geb15" style="top: 5624px;left: 9654px;"></div>
                <div class="geb geb16" style="top: 4376px;left: 9742px;"></div>
                <div class="geb geb17" style="top: 4872px;left: 10160px;"></div>
                <div class="geb geb18" style="top: 5477px;left: 9498px;"></div>
                <div class="geb geb19" style="top: 5449px;left: 10254px;"></div>
                <div class="geb geb20" style="top: 5058px;left: 10318px;"></div>
                <div class="geb geb21" style="top: 5126px;left: 10751px;"></div>
                <div class="geb geb22" style="top: 4717px;left: 10273px;"></div>
                <div class="geb geb23" style="top: 4211px;left: 10307px;"></div>
                <div class="geb geb24" style="top: 5346px;left: 10361px;"></div>
                <div class="geb geb25" style="top: 4612px;left: 10772px;"></div>
        </div>
@endsection

@section('scripts')
<script>
    function uSetting(key, value)
    {
        $.ajax({
            url: "/api/uSettings/{{uData('token')}}/"+ key +"/"+ value,
            success: function(res) {
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
        var scale = 0.1,
            panning = false,

            pointX = ( 0 - ( 1000 + width / 2 - width )),
            pointY = 0,
            start = { x: 8500, y: 0 },
            zoom = document.getElementById("zoom");

        setTransform();
        function setTransform() {
            zoom.style.transform = "translate(" + pointX + "px, " + pointY + "px) scale(" + scale + ")";
        }

        zoom.onmousedown = function (e) {
            e.preventDefault();
            start = { x: e.clientX - pointX, y: e.clientY - pointY };
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

        zoom.onwheel = function (e) {
            e.preventDefault();
                var xs = (e.clientX - pointX) / scale,
                    ys = (e.clientY - pointY) / scale,
                    delta = (e.wheelDelta ? e.wheelDelta : -e.deltaY);
            if (delta < 0 && scale > 0.2 || delta > 0) {
                (delta > 0) ? (scale *= 1.2) : (scale /= 1.2);
                pointX = e.clientX - xs * scale;
                pointY = e.clientY - ys * scale;
            }

                setTransform();
        }
    </script>
    @isset($timeend)
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
                        window.location.reload();
                    }
                }

                updateClock();
                let timeinterval = setInterval(updateClock, 1000);
            }

            initializeClock('clockdiv', new Date(Date.parse(new Date()) + {{$timeend}} * 1000));
        </script>
    @endisset
@endsection
