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
    <link href="/assets/css/2.css" rel="stylesheet">
    @yield('styles')
    <style>
        label {
            width: 100%;
        }
        input {
            width: 80%;
        }
    </style>
</head>

<body style="background-image: url('/assets/img/race.png')">


<div class="container" style="margin-top: 20px;width: 500px">
    <div class="user-message">
        <form class="row g-12" method="post" action="{{ route('Race.store') }}">
            @csrf
            <div class="text-form">
                {{--            <div class="text-form d-grid">--}}
                <div class="name-two">
                    <label for="name">
                        Name: <input type="text" placeholder="Spielername" name="name" id="name"
                                     value="{{ auth()->user()->name }}">
                    </label>
                </div>
                <div class="name-two">
                    <label for="pname">
                        Planetenname: <input type="text" placeholder="Planetname" name="pname" id="pname"
                                             value="{{ uData('planet.name') != false ? uData('planet.name'):randPlanetName() }}">
                    </label>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="custom-control custom-radio image-checkbox">
                            <input type="radio" class="custom-control-input" id="r1a" name="race" value="1">
                            <label class="custom-control-label" for="r1a">
                                <img src="/assets/img/derassenlogo1.png" alt="#" class="img-fluid">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-radio image-checkbox">
                            <input type="radio" class="custom-control-input" id="r1b" name="race" value="2">
                            <label class="custom-control-label" for="r1b">
                                <img src="/assets/img/derassenlogo2.png" alt="#" class="img-fluid">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-radio image-checkbox">
                            <input type="radio" class="custom-control-input" id="r1c" name="race" value="3">
                            <label class="custom-control-label" for="r1c">
                                <img src="/assets/img/derassenlogo3.png" alt="#" class="img-fluid">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-radio image-checkbox">
                            <input type="radio" class="custom-control-input" id="r1d" name="race" value="4">
                            <label class="custom-control-label" for="r1d">
                                <img src="/assets/img/derassenlogo4.png" alt="#" class="img-fluid">
                            </label>
                        </div>
                    </div>
                    <button class="orbit-btn" type="submit">Loslegen!</button>
                </div>
                <span class="icon"><i class="fa-solid fa-question"></i></span>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
