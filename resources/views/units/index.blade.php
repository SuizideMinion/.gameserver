@extends('layout.ingame')

@section('styles')
@endsection

@section('content')
    @include('layout/planet_navi')

    <div class="container" style="margin-top: 20px">
        <div class="row">
            <form class="row g-3" method="post" action="{{ route('kollektoren.store') }}">
                @csrf
                {{--                <div class="complete-message">--}}
                {{--                    <div class="intro">--}}
                {{--                        <h4>{{ Lang('Unit.name.1', plural: 'ja') }}</h4>--}}
                {{--                    </div>--}}
                {{--                    <div class="body-content">--}}
                {{--                        <img src="https://www.die-ewigen.com/degp3v2/g/kollie.gif" alt=""><br>--}}
                {{--                        <p>--}}
                {{--                            {{ Lang('Unit.desc.1') }}--}}
                {{--                        </p>--}}
                {{--                        <p>--}}
                {{--                            {{ Lang('kollektoren.vorhandene', [':SUM' => uData('kollektoren'), ':NAME' => Lang('Unit.name.1', plural: uData('kollektoren'))]) }}--}}
                {{--                        </p>--}}
                {{--                        <p>--}}
                {{--                            {{ Lang('kollektoren.bauzeit', [':NAME' => Lang('Unit.name.1'), ':WTICK' => Lang('Wirtschafts.Tick')]) }}--}}
                {{--                        </p>--}}
                {{--                    </div>--}}
                {{--                    <div class="actions">--}}
                {{--                        <ul>--}}
                {{--                            <li>--}}
                {{--                                <div class="heading message-input-btn">--}}
                {{--                                    <label for="b_col"></label>--}}
                {{--                                    <input type="text" id="b_col" name="b_col" value="" placeholder="0" onkeyup="calccolcost({{ uData('kollektoren') }});">--}}
                {{--                                    <input type="hidden" name="unit" value="1">--}}
                {{--                                    <button type="submit">{{ Lang('kollektoren.button.bauen') }}</button>--}}
                {{--                                </div>--}}
                {{--                            </li>--}}
                {{--                            <li>{{ ressCalc() }}--}}
                {{--                                <div class="heading" style="display:flex">--}}
                {{--                                    <p style="width: 20%">{{ Lang('kollektoren.baukosten') }}</p>--}}
                {{--                                    <p id="colmcost" style="width: 35%; text-align-last: end;"><font color="#FFFFFF">0</font></p>--}}
                {{--                                    <p id="" style="width: 5%"><font color="#FFFFFF">{{ Lang('global_ress1_name') }}</font></p>--}}
                {{--                                    <p id="coldcost" style="width: 35%; text-align-last: end;"><font color="#FFFFFF">0</font></p>--}}
                {{--                                    <p id="" style="width: 5%"><font color="#FFFFFF">{{ Lang('global_ress2_name') }}</font></p>--}}
                {{--                                </div>--}}
                {{--                            </li>--}}
                {{--                        </ul>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            </form>--}}
                @foreach($Units AS $Unit)
                    @php $getData = ( isset($Unit) ? $Unit->getData->where('race', uData('race'))->pluck('value', 'key') : '') @endphp
                    <div class="col-3">
                        <div class="heading" style="text-shadow: 2px 2px 0px black;background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/assets/{{ $getData['image'] }}');background-size: cover;">
                            <h3>{{ $getData['name'] }}</h3>
                            <p class="text-white mb-0">{{ Lang('global_ress1_name') }}:
                                <span data-value="{{ $getData['ress1'] }}" class="mc-{{ $Unit->id }} mt-0">{{ $getData['ress1'] }}</span>
                            </p>
                            <p class="text-white mb-0">{{ Lang('global_ress2_name') }}:
                                <span data-value="{{ $getData['ress2'] }}" class="dc-{{ $Unit->id }} mt-0">{{ $getData['ress2'] }}</span>
                            </p>
                            <p class="text-white mb-0">{{ Lang('global_ress3_name') }}:
                                <span data-value="{{ $getData['ress3'] }}" class="ic-{{ $Unit->id }} mt-0">{{ $getData['ress3'] }}</span>
                            </p>
                            <p class="text-white mb-0">{{ Lang('global_ress4_name') }}:
                                <span data-value="{{ $getData['ress4'] }}" class="ec-{{ $Unit->id }} mt-0">{{ $getData['ress4'] }}</span>
                            </p>
                            <p class="text-white mb-0">{{ Lang('global_ress5_name') }}:
                                <span data-value="{{ $getData['ress5'] }}" class="tc-{{ $Unit->id }} mt-0">{{ $getData['ress5'] }}</span>
                            </p>
                            <p class="text-white mb-0">{{ Lang('Buildtime') }}
                                : {{ timeconversion(10) }}</p>
                            <span>
                                <div class="text-form mt-0">
                                    <div class="password">
                                        <input onkeyup="calccolcost()" type="number" value="" placeholder="0" style="appearance: none;" name="{{ $Unit->id }}" id="value-{{ $Unit->id }}">
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                @endforeach
                <div class="agenda">
                    @foreach($userUnitsBuilds AS $Kollis)
                        <div class="agenda-one">
                            <span class="time">{{ FormatTime($Kollis->time) }}</span>
                            <ul>
                                <li>
                                <span class="agenda-name">
                                    {{ Lang('kollektoren.Warteschlange', [':NAME' => Lang('Unit.name.1', plural: $Kollis->quantity), ':SUM' => $Kollis->quantity]) }}
                                </span>
                                </li>
                                <li>
                                    <span class="green"><i class="bi bi-dot"></i></span>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </form>
            <div class="heading" style="display:flex">
                <p style="width: 20%">Baukosten:</p>
                <p id="mcost" style="width: 35%; text-align-last: end;"><font color="#FFFFFF">0</font></p>
                <p id="" style="width: 5%"><font color="#FFFFFF">{{ Lang('global_ress1_name') }}</font></p>
                <p id="dcost" style="width: 35%; text-align-last: end;"><font color="#FFFFFF">0</font></p>
                <p id="" style="width: 5%"><font color="#FFFFFF">{{ Lang('global_ress2_name') }}</font></p>
                <p id="icost" style="width: 35%; text-align-last: end;"><font color="#FFFFFF">0</font></p>
                <p id="" style="width: 5%"><font color="#FFFFFF">{{ Lang('global_ress3_name') }}</font></p>
                <p id="ecost" style="width: 35%; text-align-last: end;"><font color="#FFFFFF">0</font></p>
                <p id="" style="width: 5%"><font color="#FFFFFF">{{ Lang('global_ress4_name') }}</font></p>
                <p id="tcost" style="width: 35%; text-align-last: end;"><font color="#FFFFFF">0</font></p>
                <p id="" style="width: 5%"><font color="#FFFFFF">{{ Lang('global_ress5_name') }}</font></p>
            </div>
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
                mcost = mcost + ( $('#value-{{ $Unit->id }}').val() * $('.mc-{{ $Unit->id }}').data('value') )
                dcost = dcost + ( $('#value-{{ $Unit->id }}').val() * $('.dc-{{ $Unit->id }}').data('value') )
                icost = icost + ( $('#value-{{ $Unit->id }}').val() * $('.ic-{{ $Unit->id }}').data('value') )
                ecost = ecost + ( $('#value-{{ $Unit->id }}').val() * $('.ec-{{ $Unit->id }}').data('value') )
                tcost = tcost + ( $('#value-{{ $Unit->id }}').val() * $('.tc-{{ $Unit->id }}').data('value') )
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
