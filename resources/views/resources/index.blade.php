@extends('layout.ingame')

@section('styles')
@endsection

@section('content')
    @include('layout/planet_navi')

    <div class="container" style="margin-top: 20px">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ getImage('_1.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ Lang('global_ress1_name') }}</h5>
                        <p class="card-text">{{ Lang('global_ress1_desc') }}</p>
                        <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ getImage('_2.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ Lang('global_ress2_name') }}</h5>
                        <p class="card-text">{{ Lang('global_ress2_desc') }}</p>
                        <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ getImage('_3.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ Lang('global_ress3_name') }}</h5>
                        <p class="card-text">{{ Lang('global_ress3_desc') }}</p>
                        <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ getImage('_4.png', 'ressurcen', uData('race')) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ Lang('global_ress4_name') }}</h5>
                        <p class="card-text">{{ Lang('global_ress4_desc') }}</p>
                        <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p>
        <button onclick="notify.authorize()" control-id="ControlID-1">Authorize</button>
        <button onclick="notify.show()" control-id="ControlID-2">Show</button>
        <button onclick="notify.showDelayed(5)" control-id="ControlID-3">Show&nbsp;in&nbsp;5s</button>
        <!-- TODO : add a button that shows a notification using a 'tag' -->
    </p>
    <textarea id="console" readonly="" control-id="ControlID-4">This is the output console.
Text will appear here when stuff happens.
------------------</textarea>
@endsection

@section('scripts')
    <script type="text/javascript">
        window.onload = function() {
            window.notify = {
                list: [],
                id: 0,
                log: function(msg) {
                    var console = document.getElementById('console');
                    console.innerHTML += ("\n"+msg);
                    console.scrollTop = console.scrollHeight;
                },
                compatible: function() {
                    if (typeof Notification === 'undefined') {
                        notify.log("Notifications are not available for your browser.");
                        return false;
                    }
                    return true;
                },
                authorize: function() {
                    if (notify.compatible()) {
                        Notification.requestPermission(function(permission) {
                            notify.log("Permission to display: "+permission);
                        });
                    }
                },
                showDelayed: function(seconds) {
                    notify.log("A notification will be triggered in "+seconds+" seconds. Try minimising the browser now.");
                    setTimeout(notify.show, (seconds*1000));
                },
                show: function() {

                    if (typeof Notification === 'undefined') { notify.log("Notifications are not available for your browser."); return; }
                    if (notify.compatible()) {
                        notify.id++;
                        var id = notify.id;
                        notify.list[id] = new Notification("Notification #"+id, {
                            body: "This is the text body of the notification. \nPretty cool, huh?",
                            tag: id,
                            icon: "images/Sexy_Ben.jpeg",
                            lang: "",
                            dir: "auto",
                        });
                        notify.log("Notification #"+id+" queued for display");
                        notify.list[id].onclick = function() { notify.logEvent(id, "clicked"); };
                        notify.list[id].onshow  = function() { notify.logEvent(id, "showed");  };
                        notify.list[id].onerror = function() { notify.logEvent(id, "errored"); };
                        notify.list[id].onclose = function() { notify.logEvent(id, "closed");  };

                        console.log("Created a new notification ...");
                        console.log(notify.list[id]);
                    }
                },
                logEvent: function(id, event) {
                    notify.log("Notification #"+id+" "+event);
                }
            };
        };
    </script>
@endsection
