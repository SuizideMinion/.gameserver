
<div class="tab-main" style="margin-top: 65px;">
    <ul class="nav nav-tabs my-tab-ul" id="myTab" role="tablist">
        <li></li>
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href = '{{ route('units.index') }}';" class="nav-link {{ request()->is('units') ? 'active': ''}}" id="active-tab" data-bs-toggle="tab" data-bs-target="#active-tab-pane" type="button" role="tab" aria-controls="active-tab-pane" aria-selected="true">
                {{ Lang('global_military_unitsbuild_name') }}
            </button>
        </li>
        <li></li>
    </ul>
</div>
