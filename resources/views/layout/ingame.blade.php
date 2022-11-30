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

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Template Main JS File -->
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/main.js"></script>
@yield('scripts')

</body>

</html>
