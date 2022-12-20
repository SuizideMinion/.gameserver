@extends('layout.ingame')

@section('styles')
    <style>
        p {
            margin-bottom: 0px;
        }
    </style>
@endsection

@section('content')
    @include('layout/military_navi')

    <div class="container" style="margin-top: 20px">
        <div class="row">
            <form class="row g-3" method="post" action="{{ route('fleet.store') }}">
                @csrf

                @foreach($Units AS $Unit)
                    @php $getData = ( isset($Unit) ? $Unit->getData->where('race', uData('race'))->pluck('value', 'key') : '') @endphp
                    <div class="col-md-3">
                        <div class="heading"
                             style="text-shadow: 2px 2px 0px black;background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/assets/{{ $getData['image'] }}');background-size: cover;">
                            <h3>{{ $getData['name'] }}</h3>
                            <p class="text-white mb-0">
                                {{ Lang('military.units.available', array: [':SUM' => ($userUnits[$Unit->id] ?? 0)]) }}
                            </p>
                            <span>
                                <div class="text-form mt-0">
                                    <div class="password">
                                        <input onkeyup="setMaxValue({{ $Unit->id }}, {{ ($userUnits[$Unit->id] ?? 0 ) }})"
                                               onclick="setMaxValue({{ $Unit->id }}, {{ ($userUnits[$Unit->id] ?? 0 ) }})"
                                               type="{{( hasTech(2, $getData['build_need']) ? 'number':'hidden') }}"
                                               value="{{ ($userUnits[$Unit->id] ?? 0 ) }}"
                                               max="{{ ($userUnits[$Unit->id] ?? 0 ) }}"
                                               placeholder="0"
                                               style="appearance: none;" name="{{ $Unit->id }}"
                                               id="value-{{ $Unit->id }}">
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                @endforeach
                <div class="row heading align-items-center" style="display:flex">
                    <div class="col-6 d-flex" style="justify-content: right">
                        <div class="btn-model-one" style="zoom: 65%;margin-left: 20px;">
                            <ul>
                                <li>
                                    <button class="orbit-small" type="submit">
                                        {{ Lang('military.units.button.send') }}
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')

    <script>

        function setMaxValue(id, max)
        {
            input = document.getElementById('value-'+ id);
            if ( input.value > max)
                input.value = max;
        }

    </script>

@endsection
