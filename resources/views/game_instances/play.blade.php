@extends('layouts.frontend.app')

@section('css')
<style>
 
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
  
  #loading_screen {
      /*display: none;
      position: absolute !important;*/
      left: 0px !important;
      top: 0px !important; 
      width: 100% !important;
      height: 540px !important;
      border-radius: 5px !important;
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

  </style>


<style>

   /** Regula tamaño de juego **/
  
  #canvas-container{
    display: flex;
    align-items: center; 
    justify-content: center;
    /* border: 2px solid red; */
  }
  
  canvas {
      image-rendering: optimizeSpeed;
      -webkit-interpolation-mode: nearest-neighbor;
      -ms-touch-action: none;
  }


.fullscreen_layout {
    display: none;
    z-index: -10000;
}

.fullscreen_logo {
    width: 100px;
}

@media (max-width: 960px) and (orientation: landscape) {
    .fullscreen_layout{
        position: absolute;
        left:0;
        right: 0;
        top:0;
        bottom: 0;
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    }
}

#fit-canvas{
 
 /* border: 2px solid yellow; */
 width: 100%;
 height: 100%;
 display: flex;
  align-items: center;
  justify-content: center;
}

</style>
@endsection

@section('player')

@endsection

@section('content')
<!-- <div class="fullscreen_layoutx" onclick="toFullcanvas()">
    <div >
        <div >
            <img class="fullscreen_logo" src="\assets\img\fullscreen.svg" />
            Clic para cambiar a pantalla completa
        </div>
    </div>
</div> -->

<div class="container">
<div class="row justify-content-center pt-3">
  <div class="col-12">
    <div class="alert alert-primary p-1 pl-3">
      <div class="alert-body">
        <p class="p-0 m-0 text-center">Juega en <button class="btn btn-primary btn-sm" onclick="toFullcanvas()">pantalla completa</button></p>
      </div>
    </div>
  </div>
  <div class="bg-secondary" style="border-radius: 5px; padding:5px; box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07) !important;">
    <!--
        <button onclick="showleaderboard()">Leaderboard</button>
        <button onclick="toFullscreen()">Full screen</button>
        <button onclick="toFullcanvas()">Full canvas</button>
    -->
        <div id="canvas-container" >
            <div id="fit-canvas">
                <canvas id="canvas" width="{{$layout['w']}}" height="{{$layout['h']}}" style="border-radius: 5px; width: 100%" >
                    <p>Your browser doesn't support HTML5 canvas.</p>
                </canvas>
            </div>
            <!-- <button onclick="resizer()">c</button> -->
        </div>
    </div>


    <div id="leaderboard-container" style="{{ ($gameInstance->enable_leaderboard == 0) ? 'display:none' : '' }}" class="container pt-3">
        <div class="row">
          <div class="col-12">
            
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


    <div id="lb" class="content bg-secondary" style="display:none; border-radius: 5px; padding:5px; box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07) !important;">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <div class="box-title text-muted"><small>Tabla de puntuación - Mejores puntajes</small></div>
                
                <div class="box-tools">
                  <button onclick="update_leaderboard()">Up</button>
                </div>

              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table id="leaderboard_table" class="table table-hover table-sm">
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

    </div>

   
</div>
</div>

@endsection

@push('scripts')

<script>

$(window).on("orientationchange",function(){
 cancelFullscreen();
 resizer();
});

$('#canvas').css('width', '100%');

function resizer(){
    console.log("resizing ... ");
    //$('#canvas, #loading_screen').height($('#canvas').width() / 1.8);
    //$('#canvas, #loading_screen').css('max-height', $(window).height());
    $('#canvas, #loading_screen').css('max-width', $(window).height() * {{ $layout['proportion'] }});
}

function full(){
    $(window).off("resize");
    $('#canvas').css('height', '{{$layout["h"]}}px');
    $('#canvas').css('width', "{{$layout['w']}}px");
}

function switchFullscreen(){
    return true;
}

function toFullscreen(){
    if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        applyFullscreen();
    } else {
        cancelFullscreen();
    }
}

function applyFullscreen(){
    if (document.documentElement.requestFullScreen) {
        document.documentElement.requestFullScreen();
    } else if (document.documentElement.mozRequestFullScreen) {
        document.documentElement.mozRequestFullScreen();
    } else if (document.documentElement.webkitRequestFullScreen) {
        document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
    }
}

function cancelFullscreen(){
    if (document.cancelFullScreen) {
        document.cancelFullScreen();
    } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    } else if (document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
    }
}

function toFullcanvas(){
    if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.getElementById('canvas-container').requestFullScreen) {
            document.getElementById('canvas-container').requestFullScreen();
        } else if (document.getElementById('canvas-container').mozRequestFullScreen) {
            document.getElementById('canvas-container').mozRequestFullScreen();
        } else if (document.getElementById('canvas-container').webkitRequestFullScreen) {
            document.getElementById('canvas-container').webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
        $('#canvas').css('width', '100%');
        setTimeout(resizer, 1000)


    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
        $('#canvas').css('width', '{{$layout["w"]}}px');
    }

}


document.getElementById('canvas-container').addEventListener('fullscreenchange', (event) => {
  // document.fullscreenElement will point to the element that
  // is in fullscreen mode if there is one. If not, the value
  // of the property is null.
  if (document.fullscreenElement) {
    console.log(`Element: ${document.fullscreenElement.id} entered fullscreen mode.`);
    resizer();
  } else {
    console.log('Leaving full-screen mode.');
  }
});

function showleaderboard(){

    if($("#lb").is(":visible")){
        $("#lb").hide();
    }else{
        $("#lb").show();
    }

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


    (function($){
        $.event.special.destroyed = {
            remove: function(o) {
                if (o.handler) {
                    o.handler()
                }
            }
        }
    })(jQuery);

    $('#loading_screen').bind('destroyed', function() {
        alert("END LOAD");
    });
    
  });

</script>


<script type="text/javascript" src="/game-instances/{{$game_slug}}/{{$game_instance_slug}}/{{$jsname}}.js"></script>
<script>
window.onload = GameMaker_Init;
</script>


@endpush