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
<div class="navi"></div>
<!-- Template Main JS File -->
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/popper.min.js"></script>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/main.js"></script>
@yield('scripts')

<script>
    $(document).ready(navigation());

    function navigation() {
        $.ajax({
            url: "/Navigation/",
            success: function (res) {
                $('.navi').html(res);
                // setTimeout(function(){
                //     navigation();
                // }, 6000);
            }
        });
    }

</script>
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
