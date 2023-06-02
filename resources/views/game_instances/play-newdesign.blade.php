@extends('layouts.frontend.app')

@section('content')
    
<style>
  
  canvas {
      image-rendering: optimizeSpeed;
      -webkit-interpolation-mode: nearest-neighbor;
      -ms-touch-action: none;

  }
  
  
  #canvas {
      height: 100%;
      z-index:-1;
      border: 1px solid purple;
  }

  #overcanvas{
    background-color: #0f0404ba;
    margin-top: -540px;
    z-index: 100000;
    height: 540px;
    top: 0;
    position: relative;
    right: 0;
    width: 100%;
  }
  :-webkit-full-screen #canvas {
      width: 100%;
      height: 100%;
  }
  div.gm4html5_div_class
  {
      margin: 0px;
      padding: 0px;
      border: 0px;
  }
  
  :-webkit-full-screen {
      width: 100%;
      height: 100%;
  }
  
  canvas#loading_screen {
      position: absolute !important;
      left: 0px !important;
      top: 0px !important; 
      width: 100% !important;
      height: 540px !important;
  }

  .dialog-responsive{
    background-color: white;
    color: black;
    margin: 3px;
    max-width: 400px;
    max-height: 400px;
    margin: 0 auto;
    padding: 30px;
    border-radius: 5px;
  }

  .dialog-content{


  }

  #dialog-fullscreen{
    top:0;
    bottom: 0;
    left:0;
    right:0;
    position: relative;
  }

 #fit-canvas{
 
   border: 2px solid yellow;
 }

  </style>
  
  <div id="canvas-container" style="text-align:center; width: 100%; /* height: 540px; */ background-color: black;" > <!-- -->
    

    <div id="dialog-fullscreen" >
      <button type="button" onclick="toFullcanvas()" class="btn btn-primary">Cambiar a pantalla completa</button>
    </div>


    <div id="fit-canvas">
    <canvas id="canvas" width="960" height="540" >
        <p>Your browser doesn't support HTML5 canvas.</p>
    </canvas>
    </div>
    
    
  </div>


  <div id="leaderboard-container" class="container pt-3">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4>Juega en pantalla completa</h4>
            <p>..</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row pt-1">
      <div class="col-12">
        <div class="card">
          <div class="card-header p-0">
            <div class="row">
              <div class="col-11 p-3 pl-5">
                <b>Mayores puntajes</b>
              </div>
              <div class="col-1">
                <button onclick="update_leaderboard()">Actualizar</button>
              </div>
            </div>
          </div>
          <div class="card-body p-0">
            <table id="leaderboard_table" class="table table-hover">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Curso</th>
                  <th>Puntaje máximo</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="/game-instances/{{$game_slug}}/{{$game_instance_slug}}/{{$jsname}}.js"></script>

@endsection

@push('scripts')
<script>
  // Carga de leaderboard

function test_fullscreen(){
  $("#sidebar-wrapper").hide();
  $(".main-header").hide();
  $(".main-footer").hide()
  $(".content-wrapper").attr('style', 'margin-left: 0 !important');
  $('canvas').css('width', '100vw');
  $('canvas').css('height', '75%');
  $("#canvas-container").css('height', '100vh');
  $("#canvas-container").css('display', 'table-cell');
  $("#canvas-container").css('vertical-align', 'middle');
  $("#leaderboard-container").hide();
  document.body.webkitRequestFullscreen();
}

function update_leaderboard(){

  $("#leaderboard_table tbody tr").remove();
  $('<tr>').append(
                  $('<td>').text("Cargando ..."),
                  $('<td>').text("Cargando ..."),
                  $('<td>').text("Cargando ...")
              ).appendTo('#leaderboard_table tbody');


  $.ajax({
        type: "GET",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/experiment/{{$experiment_id}}/leaderboard" ,
    })
        .then(function(response){
          $("#leaderboard_table tbody tr").remove();
          $.each(response.lb, function(i, item) {
              var $tr = $('<tr>').append(
                  $('<td>').text(item.name),
                  $('<td>').text(item.course),
                  $('<td>').text(item.max_score)
              ).appendTo('#leaderboard_table tbody');
          });
        });
}
  
  $( document ).ready(function() {
    update_leaderboard();
    

  });
</script>

<script>

// Colapsa sidebar
var body = document.body;
body.classList.add("sidebar-collapse");

window.onload = GameMaker_Init;
function fulltoggle(){
    document.getElementById("canvas").webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
}

function closeModal(){
  $('#modal-fullscreen').modal('hide');
}
$(document).ready(function() {
  switchFullscreen();
});


function resizer(){
    console.log("resizing ... ");
    
    var w;
    if($(window).width() <= 960){
      $('#dialog-fullscreen').show();
    }else{
      $('#dialog-fullscreen').hide();
    }

  
    var h;
    if($(window).height() <= 540){
      h = $(window).height();
    }else{
      h = 540;
    } 

    $('#canvas, #loading_screen').height($('#canvas').width() / 1.8);
    $('#canvas, #loading_screen').css('max-height', $(window).height());
    $('#canvas, #loading_screen').css('max-width', $(window).height() * 1.8);
}

function resize(){
  //if(!$("#dialog-loading").is(":visible")){
    if(window.innerWidth >= 960){
      //$('#overcanvas').fadeOut();
      
    }else{
      //$('#overcanvas').fadeIn();
      $('#dialog-fullscreen').show();
    }
  //}
}

function switchFullscreen(){
  console.log("manejando el fullscreen :)");
  $('#message-fullscreen').fadeIn();
  $('#dialog-loading').hide();
  resize();
}

resizer();
$( window ).resize(function() {
  resizer();
  console.log("updating size")
});


$(window).on("orientationchange",function(){
 cancelFullscreen();
 resizer();
});

$('#canvas').css('width', '960px');
$('#canvas').css('height', '540px');

function toFullcanvas(){
    if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.getElementById('canvas-container').requestFullScreen) {
            document.getElementById('canvas-container').requestFullScreen();
        } else if (document.getElementById('canvas-container').mozRequestFullScreen) {
            document.getElementById('canvas-container').mozRequestFullScreen();
        } else if (document.getElementById('canvas-container').webkitRequestFullScreen) {
            document.getElementById('canvas-container').webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
        resizer();

    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }

}

</script>

<script src="assets/js/engine/player.js"></script>

@endpush


