
<div class="tab-main" style="margin-top: 65px;">
    <ul class="nav nav-tabs my-tab-ul" id="myTab" role="tablist">
        <li></li>
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href = '{{ route('buildings.index') }}';"
                    class="nav-link {{ request()->is('buildings') ? 'active': ''}}"
                    data-bs-toggle="tooltip"
                    data-bs-html="true"
                    data-bs-placement="bottom"
                    data-bs-original-title="<em>{{Lang('global_planet_research_name')}}</em>">
                <h2 class="" >
                    Wandlerkammer E
                </h2>
                {{ Lang('global_planet_buildings_name') }}
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href = '{{ route('researchs.index') }}';" class="nav-link {{ request()->is('researchs') ? 'active': ''}}" id="inactive-tab" data-bs-toggle="tab" data-bs-target="#inactive-tab-pane" type="button" role="tab" aria-controls="inactive-tab-pane" aria-selected="false" tabindex="-1">
                {{ Lang('global_planet_research_name') }}
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href = '{{ route('resources.index') }}';" class="nav-link {{ request()->is('resources') ? 'active': ''}}" id="inactive-tab" data-bs-toggle="tab" data-bs-target="#inactive-tab-pane" type="button" role="tab" aria-controls="inactive-tab-pane" aria-selected="false" tabindex="-1">
                {{ Lang('global_planet_ressurces_name') }}
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href = '{{ route('kollektoren.index') }}';" class="nav-link {{ request()->is('kollektoren') ? 'active': ''}}" id="inactive-tab" data-bs-toggle="tab" data-bs-target="#inactive-tab-pane" type="button" role="tab" aria-controls="inactive-tab-pane" aria-selected="false" tabindex="-1">
                {{ Lang('global_planet_kollektoren_name') }}
            </button>
        </li>
        <li></li>
    </ul>
</div>
