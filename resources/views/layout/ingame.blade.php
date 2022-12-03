<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/assets/img/favicon.png" rel="icon">
    <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Template Main CSS File -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/orbit.css" rel="stylesheet">
    <style>
        .arrow_box {
            position: relative;
            background: #2b6e82;
            border: 2px solid #c2e1f5;
        }
        .arrow_box:after, .arrow_box:before {
            top: 100%;
            left: 50%;
            border: solid transparent;
            content: "";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .arrow_box:after {
            border-color: rgba(43, 110, 130, 0);
            border-top-color: #2b6e82;
            border-width: 30px;
            margin-left: -30px;
        }
        .arrow_box:before {
            border-color: rgba(194, 225, 245, 0);
            border-top-color: #c2e1f5;
            border-width: 33px;
            margin-left: -33px;
        }
    </style>
    @yield('styles')

</head>

<body style="background-image: url('/assets/img/1.png')">

@if(session()->has('error'))
<div style="display: flex;
    bottom: 10px;
    right: 10px;
    position: fixed;
    z-index: 99">
    <div>
        <div class="arrow_box" style="max-width: 150px;color: white;text-align: -webkit-center;">{{ session()->get('error') }}</div>
        <img src="/assets/img/berater/berater{{ rand(1,11) }}.png" style="width: 150px;margin-top: 20px"></div>
</div>
@endif

    @yield('content')
<div class="ressMain">
    <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
         title="<b>{{ Lang('global_ress1_name') }}</b> <br><br><em>{{ Lang('global_ress1_desc') }}</em>">
        <img src="{{ getImage('_1.png', 'ressurcen', uData('race')) }}">
        <p>{{ number_shorten( uRess()->ress1, 0) }}</p>
    </div>
    <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
         title="<b>{{ Lang('global_ress2_name') }}</b> <br><br><em>{{ Lang('global_ress2_desc') }}</em>">
        <img src="{{ getImage('_2.png', 'ressurcen', uData('race')) }}">
        <p>{{ number_shorten( uRess()->ress2, 0) }}</p>
    </div>
    <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
         title="<b>{{ Lang('global_ress3_name') }}</b> <br><br><em>{{ Lang('global_ress3_desc') }}</em>">
        <img src="{{ getImage('_3.png', 'ressurcen', uData('race')) }}">
        <p>{{ number_shorten( uRess()->ress3, 0) }}</p>
    </div>
    <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
         title="<b>{{ Lang('global_ress4_name') }}</b> <br><br><em>{{ Lang('global_ress4_desc') }}</em>">
        <img src="{{ getImage('_4.png', 'ressurcen', uData('race')) }}">
        <p>{{ number_shorten( uRess()->ress4, 0) }}</p>
    </div>
    <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
         title="<b>{{ Lang('global_ress5_name') }}</b> <br><br><em>{{ Lang('global_ress5_desc') }}</em>">
        <img src="{{ getImage('_5.png', 'ressurcen', uData('race')) }}">
        <p>{{ number_shorten( uRess()->ress5, 0) }}</p>
    </div>
</div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<div class="race-footerl" style=""></div>
<div class="race-head" style=""></div>
<div class="race-footerr" style=""></div>
<div class="race-icon race-icona" onclick="window.location.href = '{{ route('buildings.index') }}';"><i class="bi bi-globe" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
                                     title="<b>{{ Lang('global_planet_name') }}</b> <br><br><em>{{ Lang('global_planet_desc') }}</em>"></i></div>
<div class="race-icon race-iconb"><i class="bi bi-star-fill"></i></div>
<div class="race-icon race-iconc"><i class="bi bi-star-fill"></i></div>
<div class="race-icon race-icond"><i class="bi bi-star-fill"></i></div>
<div class="race-icon race-icone"><i class="bi bi-star-fill"></i></div>
<div class="race-icon race-iconf"><i class="bi bi-star-fill"></i></div>


<!-- Template Main JS File -->
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/main.js"></script>
@yield('scripts')
<script>
    $.ajax({
        url: "/api/crown",
        success: function(res) {
            console.log(res);
        }
    });
</script>
<script>
</script>
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
                setTimeout(notify.show('text'), (seconds*1000));
            },
            show: function(time = 0, text) {
                if(time !== 0 ) setTimeout(console.log("send"), time * 1000);
                if (typeof Notification === 'undefined') { notify.log("Notifications are not available for your browser."); return; }
                if (notify.compatible()) {
                    notify.id++;
                    var id = notify.id;
                    notify.list[id] = new Notification("Notification #"+id, {
                        body: text,
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
        notify.show({{ ( (\App\Models\UserBuildings::where('user_id', auth()->user()->id)->where('value', 1)->first()->time ?? 99999999999) - time() ) }}, 'Gebäude bau Fertig')
        notify.show({{ ( (\App\Models\UserResearchs::where('user_id', auth()->user()->id)->where('value', 1)->first()->time ?? 99999999999) - time() ) }}, 'Forschung Fertig')

    };
</script>
</body>

</html>
