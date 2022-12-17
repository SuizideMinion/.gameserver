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

    <style>
        .carousel__cell {
            position: absolute;
            /*height: 500px;*/
            width: 100%;
            line-height: 26px;
            font-size: 20px;
            font-weight: normal;
            color: white;
            text-align: center;
            transition: transform 1s, opacity 1s;
            transform: rotateY(0deg) translateZ(1031px);
            border-color: white;
            border-style: ridge;
            border-radius: 20px;
        }
        p {
            margin: 0px !important;
            margin-bottom: 0px !important;
        }
    </style>

</head>

<body style="margin: 0px;padding: 0px;height: 100vh;">
<div class="carousel__cell"
     onclick="window.location.href = '{{ route('buildings.edit', $Building->id) }}';"
     style="
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
    @if($Building->can()['value'] != Lang('tech.finish'))
        <p class=""
           style="">{{ Lang('level', [':level' => (session('UserBuildings')[$Building->id]->level ?? 0) + 1], plural: (session('UserBuildings')[$Building->id]->level ?? 0) + 1) }}</p>
        <p class="m-0">{{ Lang('global_ress1_name') }}:
            <span
                class="m">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress1'] ?? 0 }}</span>
        </p>
        <p class="m-0">{{ Lang('global_ress2_name') }}:
            <span
                class="d">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress2'] ?? 0 }}</span>
        </p>
        <p class="m-0">{{ Lang('global_ress3_name') }}:
            <span
                class="i">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress3'] ?? 0 }}</span>
        </p>
        <p class="m-0">{{ Lang('global_ress4_name') }}:
            <span
                class="e">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress4'] ?? 0 }}</span>
        </p>
        <p class="m-0">{{ Lang('global_ress5_name') }}:
            <span
                class="t">{{ $Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.ress5'] ?? 0 }}</span>
        </p>
        <p class="m-0">{{ Lang('Buildtime') }}
            : {{ timeconversion($Building->pluck()[((session('UserBuildings')[$Building->id]->level ?? 0) + 1) .'.tech_build_time'] / 100 * session('ServerData')['Tech.Speed.Percent']->value) }}</p>
        <br>
        <br>
        {{--                            --}}
        @if($BuildingActive)
            @if($BuildingActive->build_id == $Building->id)
                {{ Lang('tech.imBau') }}
                @set($timeend, session('UserBuildings')[$Building->id]->time - time())
                <div id="clockdiv">
                    <span class="Timer"></span>
                </div>
            @endif
        @else
            @if(canTech(1, $Building->id, (session('UserBuildings')[$Building->id]->level ?? 0) + 1))
                <a href="{{ route('buildings.edit', $Building->id) }}" class="orbit-btn">
                    {{ Lang('tech.Button.Build.1', plural: (((session('UserBuildings')[$Building->id]->level ?? 0) + 1))) }}
                </a>
            @endif
        @endif
    @else
        <p>Maximum</p>
    @endif
</div>

<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/popper.min.js"></script>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/main.js"></script>
</body>

</html>
