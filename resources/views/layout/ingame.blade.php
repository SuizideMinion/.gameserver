<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>test DE:r ingame</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/assets/img/favicon.ico" rel="icon">
    <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Template Main CSS File -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/{{ uData('race') }}.css" rel="stylesheet">
    <link href="/assets/css/responsive.css" rel="stylesheet">
    @yield('styles')
</head>

<body>

@yield('content')
<div class="ressMain">
    <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
         title="<b>{{ Lang('global_ress1_name') }}</b><br>{{number_format(uRess()->ress1, 0, '', '.') }} <br><br><em>{{ Lang('global_ress1_desc') }}</em>">
        <img src="{{ getImage('_1.png', 'ressurcen', uData('race')) }}">
        <p>{{ number_shorten( uRess()->ress1, 0) }}</p>
    </div>
    <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
         title="<b>{{ Lang('global_ress2_name') }}</b><br>{{ number_format(uRess()->ress2, 0, '', '.') }} <br><br><em>{{ Lang('global_ress2_desc') }}</em>">
        <img src="{{ getImage('_2.png', 'ressurcen', uData('race')) }}">
        <p>{{ number_shorten( uRess()->ress2, 0) }}</p>
    </div>
    <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
         title="<b>{{ Lang('global_ress3_name') }}</b><br>{{ number_format(uRess()->ress3, 0, '', '.') }} <br><br><em>{{ Lang('global_ress3_desc') }}</em>">
        <img src="{{ getImage('_3.png', 'ressurcen', uData('race')) }}">
        <p>{{ number_shorten( uRess()->ress3, 0) }}</p>
    </div>
    <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
         title="<b>{{ Lang('global_ress4_name') }}</b><br>{{ number_format(uRess()->ress4, 0, '', '.') }} <br><br><em>{{ Lang('global_ress4_desc') }}</em>">
        <img src="{{ getImage('_4.png', 'ressurcen', uData('race')) }}">
        <p>{{ number_shorten( uRess()->ress4, 0) }}</p>
    </div>
    <div class="ress" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
         title="<b>{{ Lang('global_ress5_name') }}</b><br>{{ number_format(uRess()->ress5, 0, '', '.') }} <br><br><em>{{ Lang('global_ress5_desc') }}</em>">
        <img src="{{ getImage('_5.png', 'ressurcen', uData('race')) }}">
        <p>{{ number_shorten( uRess()->ress5, 0) }}</p>
    </div>
</div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
<div class="bottom_navi">

    @if(session()->has('error'))
        <div style="display: flex;bottom: 10px;left: 10px;position: fixed;z-index: 99">
            <div>
                <div class="arrow_box"
                     style="max-width: 150px;color: white;text-align: -webkit-center;">{{ session()->get('error') }}</div>
                <img src="/assets/img/berater/berater{{ rand(1,11) }}.png" style="width: 100px;margin-top: 20px"></div>
        </div>
    @endif

    <div class="race-footerl" style=""></div>
    <div class="race-footerr" style=""></div>

    <div class="Navigation">
        <div class="race-head" style="z-index: 1000"></div>
        <div class="race-icon race-icona" style="z-index: 1000"
             onclick="window.location.href = '{{ route('buildings.index') }}';">
            <i class="bi bi-globe" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
               title="<b>{{ Lang('global_planet_name') }}</b> <br><br><em>{{ Lang('global_planet_desc') }}</em>"></i>
        </div>
        <div class="race-icon race-iconb" style="z-index: 1000"
             onclick="window.location.href = '{{ route('map.index') }}';">
            <i class="bi bi-stars" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
               title="<b>{{ Lang('global_map_name') }}</b> <br><br><em>{{ Lang('global_map_desc') }}</em>"></i>
        </div>
        <div class="race-icon race-iconc" style="z-index: 1000"
             onclick="window.location.href = '{{ route('units.index') }}';">
            <i class="bi bi-chevron-double-up" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
               title="<b>{{ Lang('global_military_name') }}</b> <br><br><em>{{ Lang('global_military_desc') }}</em>"></i>
        </div>
        <div class="race-icon race-icond" style="z-index: 1000"
             onclick="window.location.href = '{{ route('ranking.index') }}';">
            <i class="bi bi-ladder" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
               title="<b>{{ Lang('global_ranking_name') }}</b> <br><br><em>{{ Lang('global_ranking_desc') }}</em>"></i>
        </div>
        {{--        <div class="race-icon race-icone" style="color: gray"><i class="bi bi-star-fill"></i></div>--}}
        {{--        <div class="race-icon race-iconf" style="color: gray"><i class="bi bi-star-fill"></i></div>--}}
    </div>
        <li class="nav-item dropdown pe-3"
            style="position: fixed;right: 10px;bottom: 4px;color: aliceblue;list-style: none;display: flex;">

            <a class="nav-link nav-icon" href="/logout" style="margin-right: 10px">
                <i class="bi bi-door-open-fill"></i>
            </a><!-- End logout Icon -->
        </li><!-- End Profile Nav -->
</div>

<!-- Modal -->
<div class="modal  modal-xl" id="showDialog" data-bs-keyboard="false" tabindex="-1" aria-labelledby="showDialog"
     aria-hidden="true">
    <button style="color: red;font-size: xx-large;position: fixed;right: 20px;top: 20px;z-index: 9999999" type="button"
            class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        <i class="bi bi-x-circle" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
           aria-label="close"></i>
    </button>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: transparent">
            <div class="modal-body p-0">
                ...
            </div>
        </div>
    </div>
</div>
<div id="modifiersDiv"></div>
<!-- Template Main JS File -->
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/popper.min.js"></script>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/main.js"></script>
@yield('scripts')
<script>
    $.get('/api/message/{{ uData('token') }}', function (data) {
        let obj = JSON.parse(data);

// Define recursive function to print nested values
        let c = 0;

        function printValues(obj) {
            for (var k in obj) {
                if (obj[k] instanceof Object) {
                    printValues(obj[k]);
                } else {
                    if (k === 'text') {
                        // document.write(obj['text'] + " -> " + k + "<br>");
                        if (c < 5) {
                            $(".messages").append('<li><a href="/messages/' + obj['id'] + '" class="user-message-one"><div class="user-text"><h6>' + obj['name'] + '</h6> <div class="text"> <p>' + (obj['read'] === 0 ? '<b>Neu:</b>' : '') + ' ' + obj['text'].slice(0, 50) + '...</p> </div> </div><div class="user-active"><span>4 hrs. ago</span></div></a></li>');
                            if (obj['new'] === 'ja') $(".bi-chat-left-text").css("color", "red");
                            c++;
                            // alert(c);
                        }
                    }
                }
            }
        }

        printValues(obj);
    });
    $.ajax({
        url: "/api/crown",
        success: function (res) {
            console.log(res);
        }
    });
</script>
<script type="text/javascript">
    window.onload = function () {
        window.notify = {
            list: [],
            id: 0,
            compatible: function () {
                if (typeof Notification === 'undefined') {
                    notify.log("Notifications are not available for your browser.");
                    return false;
                }
                return true;
            },
            authorize: function () {
                if (notify.compatible()) {
                    Notification.requestPermission(function (permission) {
                        notify.log("Permission to display: " + permission);
                    });
                }
            },
            showDelayed: function (seconds) {
                notify.log("A notification will be triggered in " + seconds + " seconds. Try minimising the browser now.");
                setTimeout(notify.show('text'), (seconds * 1000));
            },
            show: function (time = 0, text) {
                setTimeout(function () {
                    if (typeof Notification === 'undefined') {
                        notify.log("Notifications are not available for your browser.");
                        return;
                    }
                    if (notify.compatible()) {
                        notify.id++;
                        var id = notify.id;
                        notify.list[id] = new Notification("Notification #" + id, {
                            body: text,
                            tag: id,
                            icon: "",
                            lang: "",
                            dir: "auto",
                        });
                    }
                }, time * 1000);
            },
        };
        notify.show({{ ( (\App\Models\UserBuildings::where('user_id', auth()->user()->id)->where('value', 1)->first()->time ?? 99999999999) - time() ) }}, 'Gebäude bau Fertig')
        notify.show({{ ( (\App\Models\UserResearchs::where('user_id', auth()->user()->id)->where('value', 1)->first()->time ?? 99999999999) - time() ) }}, 'Forschung Fertig')

    };
</script>
</body>

</html>
