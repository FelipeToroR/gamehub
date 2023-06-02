@extends('layouts.app')

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
  </style>
  
  <div id="canvas-container" style="text-align:center; width: 100%; height: 540px; background-color: black;" > <!-- -->
      <canvas id="canvas" width="960" height="540" >
          <p>Your browser doesn't support HTML5 canvas.</p>
      </canvas>
      <div id="overcanvas">

        <div id="dialog-loading" class="dialog-responsive">
          <div class="dialog-content">
            Cargando ... 
          </div>
        </div>

        <div id="dialog-fullscreen"  style="display: none" class="dialog-responsive ">
          <div class="dialog-content">
            <button onclick="fulltoggle()" class="btn btn-default">
              Cambiar a pantalla completa
            </button>  
          </div>
        </div>


      </div>
  </div>

  <div id="leaderboard-container" class="container">
    <div class="row">
      <section class="content-header">
        <div id="message-fullscreen" style="display: none" class="callout callout-info">
          <h4>Juega en pantalla completa</h4>
          <p>Puedes jugar a <span onclick="test_fullscreen()">toda pantalla</span> si quieres <a href="#" onclick="fulltoggle()">¡Clic aquí para jugar a toda pantalla!</a></p>
        </div>
          
      </section>
      <div class="content">

        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Tabla de puntuación - Mejores puntajes</h3>
                
                <div class="box-tools">
                  <button onclick="update_leaderboard()">Actualizar tabla de puntajes máximos</button>
                  
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
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
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>

          <div class="clearfix"></div>

          @include('flash::message')

      

          
      </div>
    </div>
  </div>
    <!-- modal pantalla completa -->
   

    

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

function resize(){
  if(!$("#dialog-loading").is(":visible")){
    if(window.innerWidth >= 960){
      $('#overcanvas').fadeOut();
    }else{
      $('#overcanvas').fadeIn();
      $('#dialog-fullscreen').fadeIn();
    }
  }
}

function switchFullscreen(){
  console.log("manejando el fullscreen :)");
  $('#message-fullscreen').fadeIn();
  $('#dialog-loading').hide();
  resize();
}

$( window ).resize(function() {
  resize();
  console.log("updating size")
});


</script>
@endpush


