@extends('layout.ingame')

@section('styles')
    <style>
        * {
            box-sizing: border-box;
        }

        @media screen and (orientation: portrait) {

            body {
                -ms-transform: rotate(-90deg); /* IE 9 */
                -webkit-transform: rotate(-90deg); /* Chrome, Safari, Opera */
                transform: rotate(-90deg);
                overflow: scroll;
            }
        }

        .scene {
            /*border: 1px solid #CCC;*/
            position: relative;
            width: 560px;
            height: 540px;
            margin: 0px auto;
            perspective: 1000px;
            /*padding-left: 40px;*/
            top: 100px;
        }

        @media only screen and (max-height: 600px) {
            .scene {
                /*border: 1px solid #CCC;*/
                position: relative;
                width: 560px;
                height: 100vh;
                margin: 0px auto;
                perspective: 1000px;
                top: 0px;
            }
        }

        .carousel {
            width: 100%;
            height: 100%;
            position: absolute;
            transform: translateZ(-288px);
            transform-style: preserve-3d;
            transition: transform 1s;
        }

        .carousel__cell {
            position: absolute;
            width: 540px;
            height: 520px;
            left: 10px;
            top: 10px;
            line-height: 26px;
            font-size: 20px;
            font-weight: normal;
            color: white;
            text-align: center;
            transition: transform 1s, opacity 1s;
            overflow: hidden;
            transform: rotateY(0deg) translateZ(1031px);
            border-color: white;
            border-style: ridge;
            border-radius: 20px;
            background: hsla(0, 100%, 0%, 0.8);
        }

        @media only screen and (max-height: 600px) {
            .carousel__cell {
                position: absolute;
                width: 540px;
                height: 320px;
                left: 10px;
                top: 40px;
                line-height: 26px;
                font-size: 20px;
                font-weight: normal;
                color: white;
                text-align: center;
                transition: transform 1s, opacity 1s;
                overflow: hidden;
                transform: rotateY(0deg) translateZ(1031px);
                border-color: white;
                border-style: ridge;
                border-radius: 20px;
                background: hsla(0, 100%, 0%, 0.8);
            }
        }

        .carousel__cell:nth-child(1) {
            transform: rotateY(0deg) translateZ(288px);
        }

        .carousel__cell:nth-child(2) {
            transform: rotateY(40deg) translateZ(288px);
        }

        .carousel__cell:nth-child(3) {
            transform: rotateY(80deg) translateZ(288px);
        }

        .carousel__cell:nth-child(4) {
            transform: rotateY(120deg) translateZ(288px);
        }

        .carousel__cell:nth-child(5) {
            transform: rotateY(160deg) translateZ(288px);
        }

        .carousel__cell:nth-child(6) {
            transform: rotateY(200deg) translateZ(288px);
        }

        .carousel__cell:nth-child(7) {
            transform: rotateY(240deg) translateZ(288px);
        }

        .carousel__cell:nth-child(8) {
            transform: rotateY(280deg) translateZ(288px);
        }

        .carousel__cell:nth-child(9) {
            transform: rotateY(320deg) translateZ(288px);
        }


        .carousel-options {
            text-align: center;
            position: relative;
            z-index: 2;
            background: hsla(0, 0%, 100%, 0.8);
        }

        #pfeill {
            width: 50px;
            height: 50px;
            position: fixed;
            top: 50%;
            left: 5px;
            margin-left: 10px;
            margin-top: -25px;
        }

        #pfeilr {
            width: 50px;
            height: 50px;
            position: fixed;
            top: 50%;
            right: 5px;
            margin-left: 10px;
            margin-top: -25px;
        }

        .shape1, .shape2 {
            border-width: 40px;
            border-style: solid;
            height: 0;
            width: 0;
            border-color: #000 transparent transparent transparent;
            top: 10px;
            position: absolute;
        }

        .shape2 {
            top: 0px;
            border-color: #fff transparent transparent transparent;
        }

        .ressMain {
            position: fixed;
            top: 20px;
            display: flex;
            left: 50%;
            margin-left: -325px;
        }

        @media only screen and (max-height: 600px) {
            .ressMain {
                position: fixed;
                top: 10px;
                display: flex;
                left: 50%;
                margin-left: -325px;
            }
        }

        .ress {
            background-color: white;
            border-radius: 13px;
            border: 2px solid dodgerblue;
            height: 29px;
            width: 120px;
            padding: 0px;
            display: flex;
            margin-left: 10px;
        }

        .ress img {
            height: 25px;
            border-radius: 15px;
        }

        .ress p {
            padding-top: 1px;
            padding-left: 6px;
        }
    </style>
@endsection

@section('content')
    @include('layout/planet_navi')
    @set($c, 0)
    <div class="scene">
        <div class="carousel">

            @foreach($Researchs as $key => $Research)
                @if($Research->can()['notDisplay'] == 0 OR uData('show.all.Researchs') == '1')
                    @set($c, $c + 1)
                    <div class="carousel__cell"
                         onclick="window.location.href = '{{ route('researchs.edit', $Research->id) }}';"
                         style="
                             cursor: pointer;
                             background-image:
                             linear-gradient(rgba(0, 0, 0, 0.5),
                             rgba(0, 0, 0, 0.5)),
                             url('/assets/img/research/{{ $Research->pluck()['image'] ?? '' }}');
                             background-repeat: no-repeat;
                             background-size: contain;
                             ">
                        <br>
                        <h2 class="" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
                            title="<em>{{ Lang('Research.desc.'. $Research->id) }}</em>">
                            {{ Lang('Research.name.'. $Research->id) }}
                        </h2><br>
                        @if($Research->can()['value'] != 'vollAusGebaut')
                            <p class=""
                               style="">{{ Lang('level', [':level' => (session('UserResearchs')[$Research->id]->level ?? 0) + 1]) }}</p>
                            <p>{{ Lang('global_ress1_name') }}:
                                <span class="m">{{ $Research->pluck()['ress1'] ?? 0 }}</span>
                            </p>
                            <p>{{ Lang('global_ress2_name') }}:
                                <span class="d">{{ $Research->pluck()['ress2'] ?? 0 }}</span>
                            </p>
                            <p>{{ Lang('global_ress3_name') }}:
                                <span class="i">{{ $Research->pluck()['ress3'] ?? 0 }}</span>
                            </p>
                            <p>{{ Lang('global_ress4_name') }}:
                                <span class="e">{{ $Research->pluck()['ress4'] ?? 0 }}</span>
                            </p>
                            <p>{{ Lang('global_ress5_name') }}:
                                <span class="t">{{ $Research->pluck()['ress5'] ?? 0 }}</span>
                            </p>
                            <p>{{ Lang('Buildtime') }}
                                : {{ timeconversion($Research->pluck()['tech_build_time'] / 100 * session('ServerData')['Tech.Speed.Percent']->value) }}</p>
                            <br>
                            <br>

                            @if($ResearchActive)
                                @if($ResearchActive->research_id == $Research->id)

                                    {{ Lang('tech.imBau') }}
                                    @set($timeend, session('UserResearch')[$Research->id]->time - time())
                                    <div id="clockdiv">
                                        <span class="Timer"></span>
                                    </div>
                                    @set($rotate, $c)
                                @endif
                            @else
                                @if($Research->can()['value'] == 1)
                                    <button class="orbit-btn">{{ Lang('tech.Button.Research') }}</button>
                                @endif
                            @endif
                        @else
                            <p>Maximum</p>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="carousel-options" style="display: none">
        <input class="cells-range" type="range" min="3" max="15" value="9"/>
        <input type="radio" name="orientation" value="horizontal" checked/>
        <input type="radio" name="orientation" value="vertical"/>
    </div>
    <i class="bi bi-caret-left-fill" id="pfeill" style="color: white;font-size: xxx-large;"
       onclick="leftclick()"></i>
    <i class="bi bi-caret-right-fill" id="pfeilr" style="color: white;font-size: xxx-large;"
       onclick="rightclick()"></i>
@endsection

@section('scripts')

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
        var carousel = document.querySelector('.carousel');
        var cells = carousel.querySelectorAll('.carousel__cell');
        var cellCount; // cellCount set from cells-range input value
        var selectedIndex = {{($rotate ?? 1)}} - 1;
        var cellWidth = carousel.offsetWidth;
        var cellHeight = carousel.offsetHeight;
        var isHorizontal = true;
        var rotateFn = isHorizontal ? 'rotateY' : 'rotateX';
        var radius, theta;

        // console.log( cellWidth, cellHeight );

        function rotateCarousel() {
            var angle = theta * selectedIndex * -1;
            carousel.style.transform = 'translateZ(' + -radius + 'px) ' +
                rotateFn + '(' + angle + 'deg)';
        }

        // var prevButton = document.querySelector('.previous-button');
        // prevButton.addEventListener( 'click', function() {
        //     selectedIndex--;
        //     rotateCarousel();
        // });

        function leftclick() {
            selectedIndex--;
            rotateCarousel();
        };

        // var nextButton = document.querySelector('.next-button');
        // nextButton.addEventListener('click', function () {
        //     selectedIndex++;
        //     rotateCarousel();
        // });

        function rightclick() {
            selectedIndex++;
            rotateCarousel();
        };

        // var cellsRange = document.querySelector('.cells-range');
        // cellsRange.addEventListener('change', changeCarousel);
        // cellsRange.addEventListener('input', changeCarousel);


        function changeCarousel() {
            @php if(isset($c)) $c = ( $c <= 3 ? 3:$c ); @endphp
                cellCount = {{$c}};
            theta = 360 / cellCount;
            var cellSize = isHorizontal ? cellWidth : cellHeight;
            radius = Math.round((cellSize / 2) / Math.tan(Math.PI / cellCount));
            for (var i = 0; i < cells.length; i++) {
                var cell = cells[i];
                if (i < cellCount) {
                    // visible cell
                    cell.style.opacity = 1;
                    var cellAngle = theta * i;
                    cell.style.transform = rotateFn + '(' + cellAngle + 'deg) translateZ(' + radius + 'px)';
                } else {
                    // hidden cell
                    cell.style.opacity = 0;
                    cell.style.transform = 'none';
                }
            }

            rotateCarousel();
        }

        var orientationRadios = document.querySelectorAll('input[name="orientation"]');
        (function () {
            for (var i = 0; i < orientationRadios.length; i++) {
                var radio = orientationRadios[i];
                radio.addEventListener('change', onOrientationChange);
            }
        })();

        function onOrientationChange() {
            var checkedRadio = document.querySelector('input[name="orientation"]:checked');
            isHorizontal = checkedRadio.value == 'horizontal';
            rotateFn = isHorizontal ? 'rotateY' : 'rotateX';
            changeCarousel();
        }

        // set initials
        onOrientationChange();
    </script>
    @isset($timeend)
        <script>
            function getTimeRemaining(endtime) {
                const total = Date.parse(endtime) - Date.parse(new Date());
                const seconds = Math.floor((total / 1000) % 60);
                const minutes = Math.floor((total / 1000 / 60) % 60);
                const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
                const days = Math.floor(total / (1000 * 60 * 60 * 24));

                return {
                    total,
                    days,
                    hours,
                    minutes,
                    seconds
                };
            }

            function initializeClock(id, endtime) {
                const clock = document.getElementById(id);
                const Timer = clock.querySelector('.Timer');

                function updateClock() {
                    const t = getTimeRemaining(endtime);

                    Timer.innerHTML = (t.days !== 0 ? t.days + 'Tage ' : '') + ('0' + t.hours).slice(-2) + ':' + ('0' + t.minutes).slice(-2) + ':' + ('0' + t.seconds).slice(-2);

                    if (t.total <= 0) {
                        clearInterval(timeinterval);
                        Timer.innerHTML = 'Fertig!';
                    }
                }

                updateClock();
                const timeinterval = setInterval(updateClock, 1000);
            }

            //const deadline = new Date(Date.parse(new Date()) + 3600 * 1000);
            initializeClock('clockdiv', new Date(Date.parse(new Date()) + {{$timeend}} * 1000));
        </script>
    @endisset
@endsection
