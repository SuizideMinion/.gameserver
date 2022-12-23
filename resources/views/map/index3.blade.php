@extends('layout.ingame')


@section('styles')
    <style>
        body {
            overflow: hidden;
        }

        .planet {
            width: 40px;
            height: 40px;
            background-repeat: no-repeat;
            position: absolute;
            z-index: 1
        }

        #map {
            position: absolute;
            top: -{{((isset($_GET['y']) ? $_GET['y']:auth()->user()->posYmap) * 40) + 520}}px;
            left: -{{((isset($_GET['x']) ? $_GET['x']:auth()->user()->posXmap) * 40) + 520}}px;
            width: 10240px;
            height: 10240px;
        linear-gradient(to bottom, blue, white);
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
@endsection

@section('content')
    <div style="width: 100vw; height: 100vh; overflow:hidden;position:relative;">
        <div id="map" class="draggable">
            <div style="width: 100%; height: 100%;position:relative;">
                @foreach($Planets as $Planet)
{{--                    @php $getData = (isset($Planet) ? $Planet->getData->where('user_id', auth()->user()->id)->pluck('value', 'key'):false); @endphp--}}
                    <div data-id="{{$Planet->id}}" class="planet"
                         style="{{ $Planet->x == uData('x') && $Planet->y == uData('y') ? 'box-shadow: red 0px 0px 22px;border-radius: 22px;':'' }}cursor: pointer;top:{{$Planet->x * 40}}px;left:{{$Planet->y * 40}}px;background-image: url('{{ getImage($Planet->img, 'planets/ai') }}');background-size: {{$Planet->size}}px;background-position:{{$Planet->posAtMap}};">
{{--                        @if($getData) <div>TETS</div> @endif--}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div style="position:fixed;top:100px;right:20px;width:220px;z-index:9999;">
        <div class="complete-message" id="fixedInfo">
            <div class="toast-header intro d-block">Click auf einen Planeten</div>
            <div class="body-content">
                <div class="fixedName" style="color:orange;"></div>
                <div class="fixedOwner"></div>
                <div class="fixedRessurce"></div>
                <div class="fixedXY"></div>
                <div class="fixedEta"></div>
                <div class="fixedAtt"></div>
            </div>

            <div class="actions">
                <ul>
                    <li class="fbuttona">
                    </li>
                    <li class="fbuttonb">
                    </li>
                </ul>
            </div>
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
            target.on("mousewheel DOMMouseScroll", scrolled)

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

        // Erzeugen weiterer Quadrate und de Eventhandler für den Close-Button
        // document.addEventListener("DOMContentLoaded", function () {
        //     let i = 0,
        //         x0 = 0,
        //         y0 = 130;
        //     const farben = ["red", "green", "blue", "yellow", "orange", "magenta"];
        //     document.querySelector("#b1")
        //         .addEventListener("click", function () {
        //             let newdiv = document.querySelector("#Lager .draggable")
        //                 .cloneNode(true);
        //             newdiv.style.left = x0 + i * 30 + "px";
        //             newdiv.style.top = y0 + i * 30 + "px";
        //             newdiv.style.backgroundColor = farben[i % farben.length];
        //             i++;
        //             if (i > 2 * farben.length) {
        //                 i = 0;
        //                 x0 += 30;
        //             }
        //             document.querySelector("#outer")
        //                 .appendChild(newdiv);
        //         }, false);
        //     document.querySelector("#b2")
        //         .addEventListener("click", function () {
        //             let newdiv = document.querySelector("#Lager .fixed")
        //                 .cloneNode(true);
        //             document.querySelector("#outer")
        //                 .appendChild(newdiv);
        //         }, false);
        //     document.body.addEventListener("click", function (e) {
        //         if (e.target.classList && e.target.classList.contains("close")) e.target.parentNode
        //             .parentNode.removeChild(e.target.parentNode);
        //     }, false);
        // }, false);
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

        var Y = -{{((isset($_GET['y']) ? $_GET['y']:uData('y')) * 40) + 20}} + (window.innerWidth / 2);
        map.style.left = Y + 'px';

        var X = -{{((isset($_GET['x']) ? $_GET['x']:uData('x')) * 40) + 20}} + (window.innerHeight / 2);
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
