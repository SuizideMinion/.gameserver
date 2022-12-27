@extends('layout.ingame')

@section('styles')
    <style>
        body {
            overflow: hidden;
        }

        #map {
            position: absolute;
            width: 20240px;
            height: 10240px;
            display: flex;
        }

        .draggable {
            position: absolute;
            z-index: 0;
        }

        .draggable p {
            border: 1px dashed black;
            padding: .5em;
        }

        .draggable button,
        .fixed button {
            position: absolute;
            padding: .5em;
            right: 0;
            top: 0;
        }

        .Planet {
            width: 1048px;
            height: 1048px;
            background-image: url("{{getImage('.png', path: 'planets', race: uData('race'))}}");
            background-repeat: no-repeat;
            background-size: cover;
            position: absolute;
            left: calc(50% - 500px);
            top: calc(50% - 500px);
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
            width: 150px;
            height: 110px;
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
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
@endsection

@section('settings')
    <a class="dropdown-item d-flex align-items-center"
       onclick="uSetting('show.all.Buildings', {{uData('show.all.Buildings') == 1 ? 0:1}})" style="cursor: pointer">
        <i class="bi bi-person"></i>
        <span>{{uData('show.all.Buildings') == 1 ? 'nur Baubare Gebäude anzeigen':'alle Gebäude Anzeigen'}}</span>
    </a>
@endsection

@section('content')
    <div id="map" class="draggable">
        <div style="width: 100%; height: 100%;position:relative;transform-origin: 0px 0px;">
            <div class="Planet"></div>
            <div class="Moon"></div>
            <div id="dyn"></div>
            <div class=" {{ hasTech(1, 22, 2) ? 'Shield ShieldB': (hasTech(1, 22, 1) ? 'Shield': '')}}"></div>
            @foreach($Builds as $Build)
{{--            @php $test[$Build->id] = canTechnik(1, $Build['id'], $Build['level']) @endphp--}}
{{--                @if( hasTech(1, $Build['id']) OR canTechnik(1, $Build['id'], (session('UserBuildings')[$Build['id']]->level ?? 0) + 1))--}}
                @if( $Build['canBuild']['show'] == 'true' )
                    <div id="{{ (($BuildingActive->build_id ?? 0) == $Build['id'] ? 'gebactive':'') }}" class="geb"
                         onclick="showDialog('/buildings/{{ $Build['id'] }}')"
                         style="
                             top: {{ $Build['kordX'] }}px;
                             left: {{ $Build['kordY'] }}px;
                             background-image: url('{{ getImage($Build['image']) }}')
                             ">
                        {!! ($BuildingActive->build_id ?? 0) == $Build['id'] ? timerHTML('buildactive', $BuildingActive->time - time()):'' !!}
                        <span class="span-icon">
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
                    </div>
                @endif

            @endforeach
        </div>
    </div>
    <div class="navi"></div>
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
    <script>

        var planets = document.getElementsByClassName('planet');
        for (let planet of planets) {
            planet.addEventListener('click', showFixed);
        }

        let fixedInfo = $('#fixedInfo');

        function showFixed(event) {
            $.get('/map/' + event.currentTarget.dataset.id, function (data) {
                let array = JSON.parse(data);
                fixedInfo.find('.toast-header').html(array.pname !== false ? array.pname:array.name);
                fixedInfo.find('.fixedXY').html(array.x + ':' + array.y);
                fixedInfo.find('.fixedOwner').html(array.username !== false ? array.username:'');
                fixedInfo.find('.fbuttona').html('<a href="#">Geheimdienst</a>');
                fixedInfo.find('.fbuttonb').html('<a href="#">Angreifen</a>');
            });
        }

        $(document).ready(function () {
            var scroll_zoom = new ScrollZoom($('#map'), 10, 0.2)
        })

        function ScrollZoom(container, max_scale, factor) {
            var target = container.children().first()
            var size = {w: target.width(), h: target.height()}
            var pos = {x: 0, y: 0}
            var zoom_target = {x: 0, y: 0}
            var zoom_point = {x: 0, y: 0}
            var scale = 0.1
            target.css('transform-origin', '0 0')
            target.on("mousewheel DOMMouseScroll", debounce(scrolled,10))

            function debounce(func, delay){
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

            function scrolled(e) {
                var offset = container.offset()
                zoom_point.x = e.pageX - offset.left
                zoom_point.y = e.pageY - offset.top

                e.preventDefault();
                var delta = e.delta || e.originalEvent.wheelDelta;
                if (delta === undefined) {
                    //we are on firefox
                    delta = e.originalEvent.detail;
                }
                delta = Math.max(-1, Math.min(1, delta)) // cap the delta to [-1,1] for cross browser consistency

                // determine the point on where the slide is zoomed in
                zoom_target.x = (zoom_point.x - pos.x) / scale
                zoom_target.y = (zoom_point.y - pos.y) / scale

                // apply zoom
                scale += delta * factor * scale
                scale = Math.max(1, Math.min(max_scale, scale))

                // calculate x and y based on zoom
                pos.x = -zoom_target.x * scale + zoom_point.x
                pos.y = -zoom_target.y * scale + zoom_point.y


                // Make sure the slide stays in its container area when zooming out
                if (pos.x > 0)
                    pos.x = 0
                if (pos.x + size.w * scale < size.w)
                    pos.x = -size.w * (scale - 1)
                if (pos.y > 0)
                    pos.y = 0
                if (pos.y + size.h * scale < size.h)
                    pos.y = -size.h * (scale - 1)

                update()
            }

            function update() {
                target.css('transform', 'translate(' + (pos.x) + 'px,' + (pos.y) + 'px) scale(' + scale + ',' + scale + ')')
            }
        }

        // drag_n_drop.js
        // 6. 1. 2021
        // Alle Elemente mit der Klasse "draggable" werden verschiebbar gemacht
        document.addEventListener("DOMContentLoaded", function () {
            "use strict"
            // Klasse für verschiebbare Elemente
            const drag_class = "draggable";
            // Prüfen, welche Eventmodelle unterstützt werden und welches verwendet werden soll
            const pointer_event = ("PointerEvent" in window);
            const touch_event = ("TouchEvent" in window) && !pointer_event;
            // Einige Variablen
            let pos0; // Pointerposition bei down
            let start; // Position des Dragobjekts bei down
            let zmax = 0; // Start z-Index für die Dragelemente, muss evtl. angepasst werden
            let dragele = null; // Das aktuelle Dragelement
            // Bestimmen der Pointerposition
            function get_pointer_pos(e) {
                let posx = 0,
                    posy = 0;
                if (touch_event && e.targetTouches && e.targetTouches[0] && e.targetTouches[
                    0].clientX) {
                    posx = e.targetTouches[0].clientX;
                    posy = e.targetTouches[0].clientY;
                } else if (e.clientX) {
                    posx = e.clientX;
                    posy = e.clientY;
                }
                return {
                    x: posx,
                    y: posy
                };
            } // get_pointer_pos
            //Eventhandler für pointerdown, touchstart oder mousedown
            function handle_down(e) {
                const pos = get_pointer_pos(e);
                down(e, pos);
            } // handle_down
            //Eventhandler für pointermove, touchmove oder mousemove
            function handle_move(e) {
                const pos = get_pointer_pos(e);
                move(e, pos);
            } // handle_move
            //Eventhandler für pointerup, touchend oder mouseup
            function handle_up(e) {
                up(e);
            } // handle_up
            //Eventhandler für keydown
            function handle_keydown(e) {
                const keyCode = e.keyCode;
                let xwert = 0,
                    ywert = 0;
                if (keyCode && (keyCode == 27 || keyCode == 37 || keyCode == 38 || keyCode ==
                    39 || keyCode == 40)) {
                    let delta = e.shiftKey ? 10 : 1;
                    down(e, {
                        x: 0,
                        y: 0
                    });
                    switch (keyCode) {
                        case 37: // links
                            xwert = -delta;
                            break;
                        case 38: // rauf
                            ywert = -delta;
                            break;
                        case 39: // rechts
                            xwert = delta;
                            break;
                        case 40: // runter
                            ywert = delta;
                            break;
                        case 27: // Escape
                            esc();
                            up(e);
                            return;
                            break;
                    }
                    move(e, {
                        x: xwert,
                        y: ywert
                    });
                    up(e);
                }
            } // keydown
            // Auswahl des Dragelements und Start der Dragaktion
            function down(e, pos) {
                const target = parent(e.target, drag_class);
                if (target) {
                    document.body.style.touchAction = "none";
                    e.preventDefault();
                    dragele = target;
                    start = {
                        x: dragele.offsetLeft,
                        y: dragele.offsetTop
                    };
                    pos0 = pos;
                    dragele.style.zIndex = zmax;
                    dragele.focus();
                }
            } // down
            // Bewegen des Dragelements
            function move(e, pos) {
                if (dragele) {
                    e.preventDefault();
                    dragele.style.left = (start.x + pos.x - pos0.x) + "px";
                    dragele.style.top = (start.y + pos.y - pos0.y) + "px";
                }
            } // move
            // Ende der Aktion
            function up(e) {
                if (dragele) {
                    dragele = null;
                    document.body.style.touchAction = "auto";
                }
            } // up
            // Defokussieren bei ESC-Taste
            function esc() {
                if (dragele) dragele.blur();
            } // esc
            // Dragbares Element mit Tab-Index für die Fokussierbarkeit und Eventhandler für Unterdrückung der Standardaktion versehen
            function finish(ele) {
                ele.tabIndex = 0;
                if (!pointer_event) {
                    ele.addEventListener("touchmove", function (e) {
                        e.preventDefault()
                    }, false);
                }
            } // finish
            // Vorfahrenelement mit Klasse classname suchen
            function parent(child, classname) {
                if (child && "closest" in child) return child.closest("." + classname);
                let ele = child;
                while (ele) {
                    if (ele.classList && ele.classList.contains(classname)) return ele;
                    else ele = ele.parentElement;
                }
                return null;
            } // parent
            // Alle Eventhandler notieren
            if (pointer_event) {
                document.body.addEventListener("pointerdown", handle_down, false);
                document.body.addEventListener("pointermove", handle_move, false);
                document.body.addEventListener("pointerup", handle_up, false);
            } else if (touch_event) {
                document.body.addEventListener("touchstart", handle_down, false);
                document.body.addEventListener("touchmove", handle_move, false);
                document.body.addEventListener("touchend", handle_up, false);
            } else {
                document.body.addEventListener("mousedown", handle_down, false);
                document.body.addEventListener("mousemove", handle_move, false);
                document.body.addEventListener("mouseup", handle_up, false);
            }
            document.body.addEventListener("keydown", handle_keydown, false);
            // finish für alle verschiebbaren Elemente aufrufen
            const draggable = document.querySelectorAll("." + drag_class);
            for (let i = 0; i < draggable.length; i++) {
                finish(draggable[i]);
            }
            // css-Angaben für die Bedienbarkeit
            const style = document.createElement('style');
            style.innerText = "." + drag_class + ":focus { outline: 2px solid blue; } " +
                "." + drag_class +
                " { position: absolute; cursor: move; touch-action: none; } ";
            document.head.appendChild(style);
            // finish für nachträglich erzeugte verschiebbare Elemente aufrufen
            new MutationObserver(function (mutationsList) {
                for (let i = 0; i < mutationsList.length; i++) {
                    if (mutationsList[i].type === 'childList') {
                        for (let j = 0; j < mutationsList[i].addedNodes.length; j++) {
                            if (mutationsList[i].addedNodes[j].classList && mutationsList[i].addedNodes[
                                j].classList.contains(drag_class)) {
                                finish(mutationsList[i].addedNodes[j]);
                            }
                        }
                    }
                }
            })
                .observe(document.body, {
                    childList: true,
                    subtree: true
                });
        }, false); // DOMContentLoaded
        // Ende drag_n_drop.js

        var map = document.getElementById('map');
        map.addEventListener("touchend", mouseUp);
        map.addEventListener("mouseup", mouseUp);

        var Y = -10000 + ((window.innerWidth + 500) / 2);
{{--            {{((isset($_GET['y']) ? $_GET['y']:uData('y')) * 40) + 20}} + (window.innerWidth / 2);--}}
        map.style.left = Y + 'px';

        var X = -5000 + ((window.innerHeight) / 2);
{{--            {{((isset($_GET['x']) ? $_GET['x']:uData('x')) * 40) + 20}} + (window.innerHeight / 2);--}}
        map.style.top = X + 'px';
        var Intervall1;
        var Intervall2;
        var Intervall3;
        var Intervall4;
        var scrollToUp = document.getElementById("scrollup");
        scrollToUp.addEventListener("mousedown", mouseDownUp);
        scrollToUp.addEventListener("mouseup", mouseUp);
        scrollToUp.addEventListener("touchstart", mouseDownUp);
        scrollToUp.addEventListener("touchend", mouseUp);

        function mouseDownUp() {
            Intervall1 = window.setInterval(function () {
                X = X + 10;
                map.style.top = X + 'px';
            }, 1);
        }

        var scrollToRight = document.getElementById("scrollright");
        scrollToRight.addEventListener("mousedown", mouseDownRight);
        scrollToRight.addEventListener("mouseup", mouseUp);
        scrollToRight.addEventListener("touchstart", mouseDownRight);
        scrollToRight.addEventListener("touchend", mouseUp);

        function mouseDownRight() {
            Intervall2 = window.setInterval(function () {
                Y = Y - 10;
                map.style.left = Y + 'px';
            }, 1);
        }

        var scrollToLeft = document.getElementById("scrollleft");
        scrollToLeft.addEventListener("mousedown", mouseDownLeft);
        scrollToLeft.addEventListener("mouseup", mouseUp);
        scrollToLeft.addEventListener("touchstart", mouseDownLeft);
        scrollToLeft.addEventListener("touchend", mouseUp);

        function mouseDownLeft() {
            Intervall3 = window.setInterval(function () {
                Y = Y + 10;
                map.style.left = Y + 'px';
            }, 1);
        }

        var scrollToDown = document.getElementById("scrolldown");
        scrollToDown.addEventListener("mousedown", mouseDownDown);
        scrollToDown.addEventListener("mouseup", mouseUp);
        scrollToDown.addEventListener("touchstart", mouseDownDown);
        scrollToDown.addEventListener("touchend", mouseUp);

        function mouseDownDown() {
            Intervall4 = window.setInterval(function () {
                X = X - 10;
                map.style.top = X + 'px';
            }, 1);
        }

        function mouseUp() {
            window.clearInterval(Intervall1);
            window.clearInterval(Intervall2);
            window.clearInterval(Intervall3);
            window.clearInterval(Intervall4);
        }

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
@endsection
