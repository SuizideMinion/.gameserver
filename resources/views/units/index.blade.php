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
            <form class="row g-3" method="post" action="{{ route('units.store') }}">
                @csrf

                @foreach($Units AS $Unit)
                    @php $getData = ( isset($Unit) ? $Unit->getData->where('race', uData('race'))->pluck('value', 'key') : '') @endphp
                    <div class="col-md-3">
                        <div class="heading"
                             style="text-shadow: 2px 2px 0px black;background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/assets/{{ $getData['image'] }}');background-size: cover;">
                            <h3>{{ $getData['name'] }}</h3>
                            <p class="text-white mb-0">{{ Lang('military.units.here', array: [':SUM' => ($userUnits[$Unit->id] ?? 0)]) }}
                            </p>
                            <p class="text-white mb-0">{{ Lang('global_ress1_name') }}:
                                <span data-value="{{ $getData['ress1'] }}"
                                      class="mc-{{ $Unit->id }} mt-0">{{ $getData['ress1'] }}</span>
                            </p>
                            <p class="text-white mb-0">{{ Lang('global_ress2_name') }}:
                                <span data-value="{{ $getData['ress2'] }}"
                                      class="dc-{{ $Unit->id }} mt-0">{{ $getData['ress2'] }}</span>
                            </p>
                            <p class="text-white mb-0">{{ Lang('global_ress3_name') }}:
                                <span data-value="{{ $getData['ress3'] }}"
                                      class="ic-{{ $Unit->id }} mt-0">{{ $getData['ress3'] }}</span>
                            </p>
                            <p class="text-white mb-0">{{ Lang('global_ress4_name') }}:
                                <span data-value="{{ $getData['ress4'] }}"
                                      class="ec-{{ $Unit->id }} mt-0">{{ $getData['ress4'] }}</span>
                            </p>
                            <p class="text-white mb-0">{{ Lang('global_ress5_name') }}:
                                <span data-value="{{ $getData['ress5'] }}"
                                      class="tc-{{ $Unit->id }} mt-0">{{ $getData['ress5'] }}</span>
                            </p>
                            <p class="text-white mb-0">{{ Lang('Buildtime') }}:
                                {{ timeconversion( 180 * $getData['tech_build_time'] / 100 * session('ServerData')['Tech.Speed.Percent']->value ) }}</p>
                            <span>
                                <div class="text-form mt-0">
                                    <div class="password">
                                        <input onkeyup="calccolcost()" onclick="calccolcost()" type="{{( hasTech(2, $getData['build_need']) ? 'number':'hidden') }}" value=""
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
                    <p class="col-12">Baukosten:</p>
                    <div class="col-6 d-flex" style="justify-content: right">
                        <p id="mcost"><font color="#FFFFFF">0</font></p>
                        <p class="ms-1"><font color="#FFFFFF">{{ Lang('global_ress1_name') }}</font></p>
                    </div>
                    <div class="col-6 d-flex" style="justify-content: right">
                        <p id="dcost"><font color="#FFFFFF">0</font></p>
                        <p class="ms-1"><font color="#FFFFFF">{{ Lang('global_ress2_name') }}</font></p>
                    </div>
                    <div class="col-6 d-flex" style="justify-content: right">
                        <p id="icost"><font color="#FFFFFF">0</font></p>
                        <p class="ms-1"><font color="#FFFFFF">{{ Lang('global_ress3_name') }}</font></p>
                    </div>
                    <div class="col-6 d-flex" style="justify-content: right">
                        <p id="ecost"><font color="#FFFFFF">0</font></p>
                        <p class="ms-1"><font color="#FFFFFF">{{ Lang('global_ress4_name') }}</font></p>
                    </div>
                    <div class="col-6 d-flex" style="justify-content: right">
                        <p id="tcost"><font color="#FFFFFF">0</font></p>
                        <p class="ms-1"><font color="#FFFFFF">{{ Lang('global_ress5_name') }}</font></p>
                    </div>
                    <div class="col-6 d-flex" style="justify-content: right">
                        <div class="btn-model-one" style="zoom: 65%;margin-left: 20px;">
                            <ul>
                                <li>
                                    <button class="orbit-small" type="submit">
                                        Produzieren
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="agenda">
                    @foreach($userUnitsBuilds AS $Kollis)
                        <div class="agenda-one">
                            <span class="time">{{ FormatTime($Kollis->time) }}</span>
                            <ul>
                                <li>
                                <span class="agenda-name">
                                    {{ Lang('kollektoren.Warteschlange', [':NAME' => Lang('Unit.name.'. $Kollis->unit_id, plural: $Kollis->quantity), ':SUM' => $Kollis->quantity]) }}
                                </span>
                                </li>
                                <li>
                                    <span class="green">{{timeconversion($Kollis->time - time())}}</span>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        window.onload = calccolcost(0);

        function number_format(s) {
            var tf, uf, i;
            uf = "";
            s = Math.round(s);
            tf = s.toString();
            j = 0;
            for (i = (tf.length - 1); i >= 0; i--) {
                uf = tf.charAt(i) + uf;
                j++;
                if ((j === 3) && (i !== 0)) {
                    j = 0;
                    uf = "." + uf;
                }
            }
            return uf;
        }

        function calccolcost() {
            let mcost = 0;
            let dcost = 0;
            let icost = 0;
            let ecost = 0;
            let tcost = 0;
            // alert( $('#value-2').val() )
            @foreach($Units AS $Unit)
                mcost = mcost + ($('#value-{{ $Unit->id }}').val() * $('.mc-{{ $Unit->id }}').data('value'))
            dcost = dcost + ($('#value-{{ $Unit->id }}').val() * $('.dc-{{ $Unit->id }}').data('value'))
            icost = icost + ($('#value-{{ $Unit->id }}').val() * $('.ic-{{ $Unit->id }}').data('value'))
            ecost = ecost + ($('#value-{{ $Unit->id }}').val() * $('.ec-{{ $Unit->id }}').data('value'))
            tcost = tcost + ($('#value-{{ $Unit->id }}').val() * $('.tc-{{ $Unit->id }}').data('value'))
            @endforeach


            let color1 = "#FFFFFF";
            let color2 = "#FFFFFF";
            if (mcost > {{ JSONuData('ress')->ress1 }}) color1 = "#FF0000";
            if (dcost > {{ JSONuData('ress')->ress2 }}) color2 = "#FF0000";

            $("#mcost").html('<font color="' + color1 + '">' + number_format(Math.round(mcost)) + '</font>');
            $("#dcost").html('<font color="' + color2 + '">' + number_format(Math.round(dcost)) + '</font>');
            $("#icost").html('<font color="' + color2 + '">' + number_format(Math.round(icost)) + '</font>');
            $("#ecost").html('<font color="' + color2 + '">' + number_format(Math.round(ecost)) + '</font>');
            $("#tcost").html('<font color="' + color2 + '">' + number_format(Math.round(tcost)) + '</font>');
        }
    </script>

@endsection
