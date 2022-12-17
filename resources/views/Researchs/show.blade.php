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
    <style type="text/css">
        img {
            max-width: 100%;
        }

        .recent_heading h4 {
            color: #05728f;
            font-size: 21px;
            margin: auto;
        }

        .srch_bar input {
            border: 1px solid #cdcdcd;
            border-width: 0 0 1px 0;
            width: 80%;
            padding: 2px 0 4px 6px;
            background: none;
        }

        .srch_bar .input-group-addon button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            padding: 0;
            color: #707070;
            font-size: 18px;
        }

        .chat_ib h5 {
            font-size: 15px;
            color: #464646;
            margin: 0 0 8px 0;
        }

        .chat_ib h5 span {
            font-size: 13px;
            float: right;
        }

        .chat_ib p {
            font-size: 14px;
            color: #989898;
            margin: auto
        }

        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .sent_msg p {
            background: #05728f none repeat scroll 0 0;
            border-radius: 3px;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }
        .getImage{
            max-width: 100%;
            width: 50px;
            border-radius: 13px;
        }

        p {
            margin: 0px;
        }
    </style>
<body>

@if(session()->has('error'))
    <div class="heading mt-1">
        <p>{{ session()->get('error') }}</p>
    </div>
@endif
<!------ Include the above in your HEAD tag ---------->
@foreach($array as $Research)
    <div class="heading mt-1">
        <h3>
            {{ $Research['name'] }}
            @if( hasTech(2, $Research['id']) ) erforscht!
            @elseif( canTech(2, $Research['id']) ) <a href="{{ route('researchs.edit', $Research['id']) }}">Erforschen</a>
            @endif
        </h3>
        <p>
            {{ Lang('global_ress1_name') }}: {{ $Research['ress1']->value }}
            {{ Lang('global_ress2_name') }}: {{ $Research['ress2']->value }}
            {{ Lang('global_ress3_name') }}: {{ $Research['ress3']->value }}
            {{ Lang('global_ress4_name') }}: {{ $Research['ress4']->value }}
            {{ Lang('global_ress5_name') }}: {{ $Research['ress5']->value }}
        </p>
        <p class="mt-1"></p>
        <p>
            @foreach($Research['hasBuilds'] as $has)
                @if ($Research['id'] == 21)
{{--                {{dd($Research['hasBuilds'], $has)}}--}}
                @endif
                <img onclick="window.location.href = '{{ route(($has['art'] == 1 ? 'buildings':'researchs') .'.edit', $has['id']) }}';"
                     class="getImage"
                     src="{{ getImage($has['image']) }}"
                     style="{{ hasTech($has['art'], $has['id'], $has['level']) == true ? 'border: green 1px solid;': (canTech($has['art'], $has['id'], $has['level']) == true ? 'border: orange 1px solid;':'') }}"
                     data-bs-toggle="tooltip"
                     data-bs-html="true"
{{--                     {{ dd(canTech(2, 10, 1)) }}--}}
                     title="<em>{{ $has['name'] . $has['level'] }}</em><br>
                        <p>{{ Lang('global_ress1_name') }}: <span class='m'>{{ $has['ress1'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress2_name') }}: <span class='d'>{{ $has['ress2'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress3_name') }}: <span class='i'>{{ $has['ress3'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress4_name') }}: <span class='e'>{{ $has['ress4'] ?? 0 }}</span></p>
                        <p>{{ Lang('global_ress5_name') }}: <span class='t'>{{ $has['ress5'] ?? 0 }}</span></p>
{{--                        <p>{{ Lang('Buildtime') }} {{ timeconversion(($has['build_time'] ?? 0 ) / 100 * session('ServerData')['Tech.Speed.Percent']->value) }}</p>--}}
                         <b>{{ $has['desc'] }}</b>
                        <br>">
            @endforeach
        </p>
        <span><i class="fa-solid fa-angle-down"></i></span>
    </div>
@endforeach

<script src="/assets/js/jquery.js"></script>
<script type="text/javascript">
    function showResearch(id)
    {
        $(".mesgs").html(
            '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $(document).ready(function() {
            $('.mesgs').load(id);
        })
    }
</script>
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>


</body>
</html>
