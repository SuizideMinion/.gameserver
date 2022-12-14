@extends('layout.local')

@section('styles')
@endsection

@section('content')
    <div class="container" style="margin-top: 20px">
        <div class="row">
            <form class="row g-3" method="post" action="{{ route('kollektoren.store') }}">
                @csrf
                <div class="complete-message">
                    <div class="intro">
                        <h4>{{ Lang('Unit.name.1', plural: 'ja') }}</h4>
                    </div>
                    <div class="body-content">
                        <img src="https://www.die-ewigen.com/degp3v2/g/kollie.gif" alt=""><br>
                        <p>
                            {{ Lang('Unit.desc.1') }}
                        </p>
                        <p>
                            {{ Lang('kollektoren.vorhandene', [':SUM' => uData('kollektoren'), ':NAME' => Lang('Unit.name.1', plural: uData('kollektoren'))]) }}
                        </p>
                        <p>
                            {{ Lang('kollektoren.bauzeit', [':NAME' => Lang('Unit.name.1'), ':WTICK' => Lang('Wirtschafts.Tick')]) }}
                        </p>
                        @if($kollisImBau != 0)
                            <p>
                                {{ Lang('kollektoren.im.bau', [':SUM' => $kollisImBau, ':NAME' => Lang('Unit.name.1', plural: $kollisImBau)], plural: $kollisImBau) }}
                            </p>
                        @endif
                    </div>
                    <div class="actions">
                        <ul>
                            <li>
                                <div class="heading message-input-btn" style="height: 80px;">
                                    <label for="b_col"></label>
                                    <input type="text" id="b_col" name="b_col" value="" placeholder="0" onkeyup="calccolcost({{ uData('kollektoren') + $kollisImBau }});">
                                    <input type="hidden" name="unit" value="1">
                                    <button type="submit">{{ Lang('kollektoren.button.bauen') }}</button>
                                </div>
                            </li>
                            <li>
                                <div class="heading row m-0 justify-content-end">
                                    <p class="col-12 m-0" style="text-align-last: left;">{{ Lang('kollektoren.baukosten') }}</p>
                                    <p class="col-8 m-0" id="colmcost" style="text-align-last: end;"><font color="#FFFFFF">0</font></p>
                                    <p class="col-4 m-0"><font color="#FFFFFF">{{ Lang('global_ress1_name') }}</font></p>
                                    <p class="col-8 m-0" id="coldcost" style="text-align-last: end;"><font color="#FFFFFF">0</font></p>
                                    <p class="col-4 m-0"><font color="#FFFFFF">{{ Lang('global_ress2_name') }}</font></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
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
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        window.onload = calccolcost({{ uData('kollektoren') }});

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
        function calccolcost(hascol) {
            let build = parseInt($("#b_col").val());
            if (isNaN(build)) build = 0;
            let mcost = 0;
            let dcost = 0;

            for (i = 1; i <= build; i++) {
                mcost = mcost + (1000 + ((hascol * hascol / 20 * 150))) * (1 - 0);
                dcost = dcost + (100 + ((hascol * hascol / 20 * 20))) * (1 - 0);
                hascol++;
            }

            let color1 = "#FFFFFF";
            let color2 = "#FFFFFF";
            if (mcost > {{ JSONuData('ress')->ress1 }}) color1 = "#FF0000";
            if (dcost > {{ JSONuData('ress')->ress2 }}) color2 = "#FF0000";

            $("#colmcost").html('<font color="' + color1 + '">' + number_format(Math.round(mcost)) + '</font>');
            $("#coldcost").html('<font color="' + color2 + '">' + number_format(Math.round(dcost)) + '</font>');
        }
    </script>

@endsection
