@extends('layouts.app')

@section('berater')
<div class="" style="position:fixed;bottom:10px;right:50px;z-index:9999999999999;">
    <div class="bubble">Hilfe?</div>
  <img
  src="img/berater/berater{{rand(1,11)}}.png"
  alt=""
  style="height:20vh;z-index:9999;float:right;"
  data-bs-toggle="tooltip"
  data-bs-html="true"
  title="<em>Was hier?</em><br>
          hier kannst du Planeten Einnehmen oder andere Spieler Angreifen<br>
          die Planeten mit einem Punkt kann man Angreifen/Einnehmen<br>
          Grüner Punkt bedeutet diesen Planet hat noch kein Spieler eingenommen<br>
          Roter Punkt bedeutet der Planet gehört einem Spieler<br>
          umsoweiter ein Planet von deinem Heimatplaneten entfernt ist umsolänger musst du Fliegen<br>
          willst du schneller werden baue deine Triebwerke aus :)"
  >
</div>
@endsection

@section('content')
@php var_dump(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']);die; @endphp

<div id="map">
  @foreach($Planets as $Planet)
  <div data-id="{{$Planet->id}}" class="planet" style="top:{{$Planet->x * 40}}px;left:{{$Planet->y * 40}}px;background-image: url('{{asset('/img/'.$Planet->img)}}');background-size: {{$Planet->size}}px;background-position:{{$Planet->posAtMap}};">
      @if( $Planet->owner == 0 )
      <img src="/img/pPlanets/ps_0.gif" width="10px" alt="">
      @elseif($Planet->owner == auth()->user()->id)
      <img src="/img/pPlanets/ps_1.gif" width="10px" alt="">
      @else
      <img src="/img/pPlanets/ps_2.gif" width="10px" alt="">
      @endif
      @if($UserSkill->skill_update === 9999 AND $UserSkill->planet == $Planet->id)
      <img src="/img/pPlanets/att.png" style="position: absolute;width: 40px;left: 0px;" alt="">
      @endif
  </div>
  @endforeach
  @php  //var_dump(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']);die; @endphp
  @foreach($Users as $User)
  <div data-id="u{{$User->id}}" class="planet" style="top:{{$User->posXmap * 40}}px;left:{{$User->posYmap * 40}}px;background-image: url('{{asset('/img/pPlanets/'.$User->mapPlanetImg)}}');background-size: cover;background-repeat: no-repeat;position: absolute;z-index:1">
    <img src="/img/pPlanets/orlando.png" width="20px">
  </div>
  @endforeach
</div>
<div style="position:fixed;top:100px;right:20px;width:200px;z-index:9999;">
    <div class="toast show" id="planetInfo" >
        <div class="toast-header">
            @if($errors->any())
                      <h4>{{$errors->first()}}</h4>
            @endif</div>
        <div class="toast-body" style="text-align: center;color: black;">
            <div class="planetName" style="color:orange;"></div>
            <div class="planetOwner"></div>
            <div class="planetRessurce"></div>
            <div class="planetXY"></div>
            <div class="planetEta"></div>
            <div class="planetAtt"></div>
        </div>
    </div>
    <div class="toast show" id="fixedInfo">
        <div class="toast-header">Click auf einen Planeten</div>
        <div class="toast-body" style="text-align: center;color: black;">
            <div class="fixedName" style="color:orange;"></div>
            <div class="fixedOwner"></div>
            <div class="fixedRessurce"></div>
            <div class="fixedXY"></div>
            <div class="fixedEta"></div>
            <div class="fixedAtt"></div>
        </div>
    </div>
</div>
<i id="scrollright" class="arr-right" style="position: fixed;right: 10px;top: 50%;font-size:xxx-large;"></i>
<i id="scrollleft" class="arr-left" style="position: fixed;left: 10px;top: 50%;font-size:xxx-large;"></i>
<i id="scrollup" class="arr-up" style="position: fixed;right: calc(50% - 20px);top: 101px;font-size:xxx-large;z-index:9999;"></i>
<i id="scrolldown" class="arr-down" style="position: fixed;bottom: 10px;right: calc(50% - 20px);font-size:xxx-large;"></i>

@endsection
@section('styles')
<style>
    body {
      overflow: hidden;
    }
    .planet {
      width:40px;
      height:40px;
      background-repeat: no-repeat;
      position: absolute;
      z-index:1
    }
    .popover-body {
        text-align: center;
    }
    #map {
        //background-image: url('imgs/1.png');
        position: absolute;
        top: -5120px;
        left: -5120px;
        width: 10240px;
        height: 10240px;
        linear-gradient(to bottom, blue, white);
        display: flex;
    }

    /* RESPONSIVE ARROWS */
    [class^=arr-] {
        border: solid currentColor;
        border-width: 0 .2em .2em 0;
        display: inline-block;
        padding: .20em;
        color: white;
    }

    .arr-right {
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
    }

    .arr-left {
        transform: rotate(135deg);
        -webkit-transform: rotate(135deg);
    }

    .arr-up {
        transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
    }

    .arr-down {
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
    }
</style>
@endsection
@section('scripts')
<script>
    var planets = document.getElementsByClassName('planet');
    for(let planet of planets) {
      planet.addEventListener('mouseenter', showPlanet);
      planet.addEventListener('click', showFixed);
    }
    let planetInfo = $('#planetInfo');
    function showPlanet(event) {
      $.get('/map/'+ event.currentTarget.dataset.id, function(data){
        planetInfo.find('.toast-header').html(data.Planet.name);
        planetInfo.find('.planetOwner').html(data.Function.Owner);
        planetInfo.find('.planetRessurce').html(data.Function.Ress);
        planetInfo.find('.planetXY').html(data.Function.x + ':' + data.Function.y);
        planetInfo.find('.planetEta').html(data.Function.FlightTime);
      });
    }
    let fixedInfo = $('#fixedInfo');
    function showFixed(event) {
      $.get('/map/'+ event.currentTarget.dataset.id, function(data){
        // $('#fixedInfo').addClass("show");
        fixedInfo.find('.toast-header').html(data.Planet.name);
        fixedInfo.find('.fixedOwner').html(data.Function.Owner);
        fixedInfo.find('.fixedRessurce').html(data.Function.Ress);
        fixedInfo.find('.fixedXY').html(data.Function.x + ':' + data.Function.y);
        fixedInfo.find('.fixedEta').html(data.Function.FlightTime);
        fixedInfo.find('.fixedAtt').html(data.Function.canAttack);
      });
    }

    var map = document.getElementById('map');
    map.addEventListener("touchend", mouseUp);
    map.addEventListener("mouseup", mouseUp);

    var Y = -{{((isset($_GET['y']) ? $_GET['y']:auth()->user()->posYmap) * 40) + 20}} + (window.innerWidth / 2);
    map.style.left = Y + 'px';

    var X = -{{((isset($_GET['x']) ? $_GET['x']:auth()->user()->posXmap) * 40) + 20}} + (window.innerHeight / 2);
    map.style.top = X + 'px';
    var Intervall1;
    var Intervall2;
    var Intervall3;
    var Intervall4;
    var scrollToUp = document.getElementById("scrollup");
    scrollToUp.addEventListener("mousedown", mouseDownUp);
    scrollToUp.addEventListener("mouseup", mouseUp);
    scrollToUp.addEventListener("touchstart", mouseDownUp);
    scrollToUp.addEventListener("touchend", mouseUp);

    function mouseDownUp() {
        Intervall1 = window.setInterval(function() {
            X = X + 10;
            map.style.top = X + 'px';
        }, 1);
    }

    var scrollToRight = document.getElementById("scrollright");
    scrollToRight.addEventListener("mousedown", mouseDownRight);
    scrollToRight.addEventListener("mouseup", mouseUp);
    scrollToRight.addEventListener("touchstart", mouseDownRight);
    scrollToRight.addEventListener("touchend", mouseUp);

    function mouseDownRight() {
        Intervall2 = window.setInterval(function() {
            Y = Y - 10;
            map.style.left = Y + 'px';
        }, 1);
    }

    var scrollToLeft = document.getElementById("scrollleft");
    scrollToLeft.addEventListener("mousedown", mouseDownLeft);
    scrollToLeft.addEventListener("mouseup", mouseUp);
    scrollToLeft.addEventListener("touchstart", mouseDownLeft);
    scrollToLeft.addEventListener("touchend", mouseUp);

    function mouseDownLeft() {
        Intervall3 = window.setInterval(function() {
            Y = Y + 10;
            map.style.left = Y + 'px';
        }, 1);
    }

    var scrollToDown = document.getElementById("scrolldown");
    scrollToDown.addEventListener("mousedown", mouseDownDown);
    scrollToDown.addEventListener("mouseup", mouseUp);
    scrollToDown.addEventListener("touchstart", mouseDownDown);
    scrollToDown.addEventListener("touchend", mouseUp);

    function mouseDownDown() {
        Intervall4 = window.setInterval(function() {
            X = X - 10;
            map.style.top = X + 'px';
        }, 1);
    }

    function mouseUp() {
        window.clearInterval(Intervall1);
        window.clearInterval(Intervall2);
        window.clearInterval(Intervall3);
        window.clearInterval(Intervall4);
    }
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl)
    })
</script>
@endsection
