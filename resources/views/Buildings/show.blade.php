@extends('layout.local')

@section('styles')
@endsection

@section('content')
<div class="carousel__cell"
     onclick="window.location.href = '{{ route('buildings.edit', $Building->id) }}';"
     style="
         background-image:
         linear-gradient(rgba(0, 0, 0, 0.5),
         rgba(0, 0, 0, 0.5)),
         url('/assets/img/technologies/{{ $Building->pluck()['1.image'] }}');
         background-repeat: no-repeat;
         background-size: contain;
         width: 100%;
         ">
    <br>
    <h2 class="" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
        title="<em>{{ Lang('Building.desc.'. $Building->id) }}</em>">
        {{ Lang('planet.building.name', array: [':NAME' => Lang('Building.name.'. $Building->id), ':LEVEL' => (session('UserBuildings')[$Building->id]->level ?? 0), ':MAX' => $Building->pluck()['1.max_level'] ]) }}
    </h2><br>
    @if($Building->can()['value'] != Lang('planet.building.completed'))
        <p class=""
           style="">{{ Lang('planet.building.build', [':level' => (session('UserBuildings')[$Building->id]->level ?? 0) + 1], plural: (session('UserBuildings')[$Building->id]->level ?? 0) + 1) }}</p>
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
                {{ Lang('planet.building.active') }}
                @set($timeend, session('UserBuildings')[$Building->id]->time - time())
                <div id="clockdiv">
                    <span class="Timer"></span>
                </div>
            @endif
        @else
            @if(canTech(1, $Building->id, (session('UserBuildings')[$Building->id]->level ?? 0) + 1))
                <a href="{{ route('buildings.edit', $Building->id) }}" class="orbit-btn">
                    {{ Lang('planet.buildings.Button.Build', plural: (((session('UserBuildings')[$Building->id]->level ?? 0) + 1))) }}
                </a>
            @endif
        @endif
    @else
        <p>Maximum</p>
    @endif
</div>

@endsection

@section('scripts')

    <script>
    </script>

@endsection
