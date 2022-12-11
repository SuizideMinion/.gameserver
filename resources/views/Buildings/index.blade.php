@extends('layout.ingame')

@section('styles')
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
    <div class="scene">
        <div class="carousel">

            @foreach($Buildings as $key => $Building)
                @if($Building->can()['notDisplay'] == 0 OR uData('show.all.Buildings') == '1')
                    @set($c, $c + 1)
                    <div class="carousel__cell"
                         style="
                             cursor: pointer;
                             background-image:
                             linear-gradient(rgba(0, 0, 0, 0.5),
                             rgba(0, 0, 0, 0.5)),
                             url('/assets/img/technologies/{{ $Building->pluck()['1.image'] }}');
                             background-repeat: no-repeat;
                             background-size: contain;
                             ">
                        <br>
                        <h2 class="" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
                            title="<em>{{ Lang('Building.desc.'. $Building->id) }}</em>">
                            {{ Lang('Building.name.'. $Building->id) }}
                        </h2><br>
                        @if($Building->can()['value'] != 'vollAusGebaut')
                            <p class=""
                               style="">{{ Lang('level', [':level' => (session('UserBuildings')[$Building->id]->level ?? 0) + 1], plural: (session('UserBuildings')[$Building->id]->level ?? 0) + 1) }}</p>
                            <p>{{ Lang('global_ress1_name') }}:
                                <span class="m">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress1'] ?? 0 }}</span>
                            </p>
                            <p>{{ Lang('global_ress2_name') }}:
                                <span class="d">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress2'] ?? 0 }}</span>
                            </p>
                            <p>{{ Lang('global_ress3_name') }}:
                                <span class="i">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress3'] ?? 0 }}</span>
                            </p>
                            <p>{{ Lang('global_ress4_name') }}:
                                <span class="e">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress4'] ?? 0 }}</span>
                            </p>
                            <p>{{ Lang('global_ress5_name') }}:
                                <span class="t">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress5'] ?? 0 }}</span>
                            </p>
                            <p>{{ Lang('Buildtime') }}
                                : {{ timeconversion($Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.tech_build_time'] / 100 * session('ServerData')['Tech.Speed.Percent']->value) }}</p>
                            <br>
                            <br>
{{--                            {{$Building->can()['value']}}--}}
                            @if($BuildingActive)
                                @if($BuildingActive->build_id == $Building->id)
                                    {{ Lang('tech.imBau') }}
                                    @set($timeend, session('UserBuildings')[$Building->id]->time - time())
                                    <div id="clockdiv">
                                        <span class="Timer"></span>
                                    </div>
                                    @set($rotate, $c)
                                @endif
                            @else
                                @if($Building->can()['value'] == 1)
                                    <button onclick="window.location.href = '{{ route('buildings.edit', $Building->id) }}';" class="orbit-btn">{{ Lang('tech.Button.Build.1', plural: (((session('UserBuildings')[$Building->id]->level ?? 0) + 1))) }}</button>
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
        let carousel = document.querySelector('.carousel');
        let cells = carousel.querySelectorAll('.carousel__cell');
        let cellCount; // cellCount set from cells-range input value
        let selectedIndex = {{($rotate ?? 1)}} - 1;
        let cellWidth = carousel.offsetWidth;
        let cellHeight = carousel.offsetHeight;
        let isHorizontal = true;
        let rotateFn = isHorizontal ? 'rotateY' : 'rotateX';
        let radius, theta;

        function rotateCarousel() {
            let angle = theta * selectedIndex * -1;
            carousel.style.transform = 'translateZ(' + -radius + 'px) ' +
                rotateFn + '(' + angle + 'deg)';
        }

        function leftclick() {
            selectedIndex--;
            rotateCarousel();
        }

        function rightclick() {
            selectedIndex++;
            rotateCarousel();
        }

        function changeCarousel() {
            @php if(isset($c)) $c = ( $c <= 3 ? 3:$c ); @endphp
                cellCount = {{$c}};
            theta = 360 / cellCount;
            let cellSize = isHorizontal ? cellWidth : cellHeight;
            radius = Math.round((cellSize / 2) / Math.tan(Math.PI / cellCount));
            for (let i = 0; i < cells.length; i++) {
                let cell = cells[i];
                if (i < cellCount) {
                    // visible cell
                    cell.style.opacity = 1;
                    let cellAngle = theta * i;
                    cell.style.transform = rotateFn + '(' + cellAngle + 'deg) translateZ(' + radius + 'px)';
                } else {
                    // hidden cell
                    cell.style.opacity = 0;
                    cell.style.transform = 'none';
                }
            }

            rotateCarousel();
        }

        let orientationRadios = document.querySelectorAll('input[name="orientation"]');
        (function () {
            for (let i = 0; i < orientationRadios.length; i++) {
                let radio = orientationRadios[i];
                radio.addEventListener('change', onOrientationChange);
            }
        })();

        function onOrientationChange() {
            let checkedRadio = document.querySelector('input[name="orientation"]:checked');
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
                    }
                }

                updateClock();
                let timeinterval = setInterval(updateClock, 1000);
            }

            initializeClock('clockdiv', new Date(Date.parse(new Date()) + {{$timeend}} * 1000));
        </script>
    @endisset
@endsection
