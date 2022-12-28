@extends('layout.local')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="agenda">
                @foreach($Skills AS $Skill)
                    <div class="agenda-one">
                        <span class="time">{{ ($UserSkills[$Skill->id]->level ?? 0) }}</span>
                        <ul>
                            <li>
                                <span class="agenda-name">
                                    {{ Lang('Skills.Name.'. $Skill->id) }} Dauer: {{ timeconversion(getUserSkillTime($Skill->id)) }}
                                </span>
                            </li>
                            <li>
                                <span class="green">
                                    @if ( $UserSkillsActive )
                                        @if ( $UserSkillsActive->skill_id == $Skill->id )
                                            {!! timerHTML('SkillIndex'. $UserSkillsActive->time .'Active', $UserSkillsActive->time - time()) !!}
                                        @endif
                                    @else
{{--                                        <form method="post" action="{{ route('skills.update', $Skill->id) }}">--}}
{{--                                            @csrf--}}
{{--                                            @method('PUT')--}}
                                            <a onclick="updateDialog('{{ $Skill->id }}')" data-bs-dismiss="modal" aria-label="Close" class="orbit-btn">Skillen</a>
{{--                                        </form>--}}
                                    @endif
                                </span>
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
    function updateDialog(id) {
        $.ajax({
            url: "/skills/" + id + "/edit",
            success: function (res) {
                console.log(res);
                location.reload()
            }
        });
    }
</script>
{{--    <script>--}}
{{--        window.onload = calccolcost({{ uData('kollektoren') }});--}}

{{--        function number_format(s) {--}}
{{--            var tf, uf, i;--}}
{{--            uf = "";--}}
{{--            s = Math.round(s);--}}
{{--            tf = s.toString();--}}
{{--            j = 0;--}}
{{--            for (i = (tf.length - 1); i >= 0; i--) {--}}
{{--                uf = tf.charAt(i) + uf;--}}
{{--                j++;--}}
{{--                if ((j === 3) && (i !== 0)) {--}}
{{--                    j = 0;--}}
{{--                    uf = "." + uf;--}}
{{--                }--}}
{{--            }--}}
{{--            return uf;--}}
{{--        }--}}
{{--        function calccolcost(hascol) {--}}
{{--            let build = parseInt($("#b_col").val());--}}
{{--            if (isNaN(build)) build = 0;--}}
{{--            let mcost = 0;--}}
{{--            let dcost = 0;--}}

{{--            for (i = 1; i <= build; i++) {--}}
{{--                mcost = mcost + (1000 + ((hascol * hascol / 20 * 150))) * (1 - 0);--}}
{{--                dcost = dcost + (100 + ((hascol * hascol / 20 * 20))) * (1 - 0);--}}
{{--                hascol++;--}}
{{--            }--}}

{{--            let color1 = "#FFFFFF";--}}
{{--            let color2 = "#FFFFFF";--}}
{{--            if (mcost > {{ JSONuData('ress')->ress1 }}) color1 = "#FF0000";--}}
{{--            if (dcost > {{ JSONuData('ress')->ress2 }}) color2 = "#FF0000";--}}

{{--            $("#colmcost").html('<font color="' + color1 + '">' + number_format(Math.round(mcost)) + '</font>');--}}
{{--            $("#coldcost").html('<font color="' + color2 + '">' + number_format(Math.round(dcost)) + '</font>');--}}
{{--        }--}}
{{--    </script>--}}

@endsection
