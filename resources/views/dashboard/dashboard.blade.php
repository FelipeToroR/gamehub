@extends('layouts.frontend.app')

@section('content')
<style>
.col-centered{
    float: none;
    margin: 0 auto;
}

.bg-profile{
  background-image: url('/assets/gamification/bg-profile.gif');
  width: 100%;
  height: 50px;
  position: relative;
  background-repeat: repeat;
  background-position: 0 0;
  background-size: auto 250%;
/*adjust s value for speed*/
  animation: animatedBackground 1200s linear infinite;
}

@keyframes animatedBackground {
  from {
    background-position: 0 0;
  }
/*use negative width if you want it to flow right to left else and positive for left to right*/
  to {
    background-position: -10000px 0;
  }
}


/**
RESPONSIVE
*/



/* Small devices (landscape phones, 576px and up) */
@media (max-width: 576px) { 
  
  .card-score .card-body {
    padding: 0.5rem;
  }

  .card-score h5.card-title{
    font-size: 0.8rem;
  }

  .card-score span.h2{
    font-size: 1rem;
  }

  .card-score .icon-responsive {
    width: 2.5rem;
    height: 2.5rem;
    padding: 5px;
  }
}

/* Medium devices (tablets, 768px and up) */
@media (max-width: 768px) { 


  .icon-responsive {
    width: 3rem;
    height: 3rem;
  }
}

/* Large devices (desktops, 992px and up) */
@media (max-width: 992px) { 
  .icon-responsive {
    width: 4rem;
    height: 4rem;
}
 }

/* Extra large devices (large desktops, 1200px and up) */
@media (max-width: 1200px) { 
  
  .icon-responsive {
    width: 5rem;
    height: 5rem;
  }
}




/**
Profile IDEA
*/

.card-profile-image
{
}
.card-profile-image img
{

    width: 90px;
    height: 90px;



    border: 3px solid #fff;
    border-radius: .375rem;
}


.card-profile-stats
{
    padding: 1rem 0;
}
.card-profile-stats > div
{
    margin-right: 1rem;
    padding: .875rem; 

    text-align: center;
}
.card-profile-stats > div:last-child
{
    margin-right: 0;
}
.card-profile-stats > div .heading
{
    font-size: 1.1rem;
    font-weight: bold;

    display: block;
}

</style>

<input type="hidden" id="token" value="{{$token}}" />

<!-- Modal -->
<div class="modal fade" id="rewardAcquiredModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">¡Recompensa obtenida!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="reward-acquired-modal-body">
        <p id="reward-message">rr gg gdd</p>
      </div>
      <div class="modal-footer p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rewardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Recompensa diaria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="reward-modal-body">
        
      </div>
      <div class="modal-footer p-0">
        <button type="button" class="btn btn-block btn-lg btn-success" onclick="claimReward(this)">¡RECLAMAR RECOMPENSA!</button>
      </div>
    </div>
  </div>
</div>


<div class="header">
  <div class="header bg-transparent bg-cloudxx" style="height: 100%">
    <div class="container">
      <div class="header-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-profile mt-5">              
              <div class="row">
                <div class="col-lg-6">
                  <!-- CARD USER -->
                  <div class="card-body pt-1 pb-1">
                    <div class="text-left row">
                      <div class="col-lg-3 p-2 d-none d-lg-block">
                        <div class="card-profile-imagxe">
                          <a href="#">
                            <img src="http://lorempixel.com/180/180/abstract/" class="img-fluid img-thumbnail">
                          </a>
                        </div>
                      </div>
                      <div class="col-lg-7">
                        <h5 class="h4">
                          {{$user->name}}
                        </h5>
                        <div class="h5 font-weight-300">
                          <i class="ni location_pin"></i>{{$user->course}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- CARD USER // end -->
                </div> <!-- end // COL-L6 -->
                <div class="col-lg-6">
                  <!-- CARD COUNTERS -->
                  <div class="card-header text-center pt-2 pb-2" style="height: 100%">
                    <div class="row d-flex justify-content-between">
                      <!-- BLOQUE COINS -->
                      <div class="col-sm-6 pr-sm-1 pl-sm-1 pr-md-1 pl-md-1">
                        <div class="card card-expansible bg-white mt-2">
                          <div class="card-body p-2">
                            <div class="row d-flex justify-content-center text-center">
                              <div class="col-8">
                                <P class="pb-0 mb-0">MONEDAS</P>
                                <span id="currency_text" class="h2 font-weight-bold mb-0 text-right">{{$currency_amount ?? 0}}</span>
                              </div>
                              <div class="col-4">
                                <div id="currency-icon" class="icon icon-shape icon-responsive bg-gradient-orange text-white rounded-circle shadow">
                                  <img src="\public\assets\gamification\coin.gif" class="img-fluid" />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div> <!-- end // col-sm-5 -->
                      <!-- end // BLOQUE COINS -->
                      <!-- BLOQUE EXPERIENCIA -->
                      <div class="col-sm-6 pr-sm-1 pl-sm-1 pr-md-1 pl-md-1">
                        <div class="card card-expansible bg-white mt-2">
                          <div class="card-body p-2">
                            <div class="row d-flex justify-content-center text-center">
                              <div class="col-8">
                                <P class="pb-0 mb-0">EXPERIENCIA</P>
                                <span id="experience_text" class="h2 font-weight-bold mb-0 text-right">{{$experience_amount ?? 0}}</span>
                              </div>
                              <div class="col-4">
                                <div class="icon icon-shape icon-responsive bg-gradient-orange text-white rounded-circle shadow">
                                  <img src="\public\assets\gamification\experience.gif" class="img-fluid" />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div> <!-- end // col-sm-5 -->
                      <!-- end // BLOQUE EXPERIENCIA -->
                    </div>
                  </div> <!-- end // card-header -->
                  <!-- end // CARD COUNTERS -->
                </div>
              </div><!-- end ROW -->
            </div>
          </div>

          @if($gameInstance->enable_performance_chart == 1)
          <div class="col-sm-8 pr-sm-1 pr-md-0">
            <div class="card card-expansible bg-white mt-2">
              <div class="card-header">
                Últimos puntajes alcanzados 
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="chart-bars" class="chart-canvas"></canvas>
                </div>
              </div>
              <!-- <div class="card-footer">
                <button class="btn btn-success" onclick="pushCurrency()">Ganar moneda</button>
              </div> -->
            </div>
          </div>
          @endif
          
          
          <div class="col-sm-4">
            <div class="card card-expansible bg-white mt-2">
              <div class="card-header p-2">
                <a href="{{route('game-instances.goto-game',[$experiment_id, $game_instance_id])}}" class="btn btn-block btn-xl btn-success">
                  ¡ Jugar ahora !
                </a>
              </div>
              <div class="card-body text-center">
                <h4>Avance actual</h4>
                <p>{{$actual_advances}} / {{$required_advances}}</p>
               <!-- <p >Experimento: {{$experiment_id}}</h5>
                <p >Instancia de juego: {{$game_instance_id}}</h5> -->
              </div>
            </div>
          </div>


          @if($gameInstance->enable_badges == 1)
          <div class="col-sm-8 pr-0 d-sm-none d-md-block">
            <div class="card card-expansible bg-white mt-2">
              <div class="card-header">
                Medallas adquiridas
              </div>
              <div class="card-body p-2">
                <div class="row">
                @foreach($badges as $key => $value)
                  <div class="col-3 text-center mx-auto d-block">
                    <img src="/badges/{{ $value->game_badge_id}}/image" class="img-fluid img-responsive" />
                    <p>{{ $value->name }}</p>
                  </div>
                @endforeach
                </div>
              </div>
            </div>
          </div>
          @endif

        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script src="/vendor/chart.js/dist/Chart.min.js"></script>
<script src="/vendor/chart.js/dist/Chart.extension.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
<script>
$("#getting-started")
  .countdown({{$remaining_time_next_reward}}, function(event) {
    $(this).text(
      event.strftime('%H:%M:%S')
    );
  });
</script>

<script>
/* Carga desde el inicio */
/** Presenta cuadro de dialogo de recompensa*/
loadReward();
loadChart();

function loadChart(){

  if($('#chart-bars').length > 0){
    $.ajax({
      url: '{{route('dashboard.performance')}}',
      type: 'GET',
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        game:{
          token: $("#token").val()
        }
      },
      success: function(response){
        // Actualiza monto
        if(response && response.chart){
          var ctx = document.getElementById('chart-bars');
          var myChart = new Chart(ctx, response.chart);
        }
      }
    });
  }

}


/** Reclamar monto */
function pushCurrency(amount){

  $.ajax({
    url: '{{route('scores.currency.buy')}}',
    type: 'POST',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      game:{
        token: $("#token").val()
      },
      currency:{
        cost: amount
      }
    },
    success: function(response){
      // Actualiza monto
      if(response && response.currency){
        $("#currency_text").text(response.currency);
      }
    }
  });
}

function loadReward(){


  if({{$show_reward}} > 0){
    $.LoadingOverlay("show",{
      background: "rgba(165, 190, 100, 0.5)"
    }); 
    $.ajax({
      url: '{{route('rewards.modal')}}',
      type: 'POST',
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        game_instance_id: {{ $game_instance_id }}
      },
      success: function(response){ 
        $('.modal-body').html(response);
        $('#rewardModal').modal({
          backdrop: 'static',
          keyboard: false,
          show: true
        }); 
        $.LoadingOverlay("hide");
      }
    });
  }
}

function claimReward(me){


  $.ajax({
    url: '{{route('rewards.request')}}',
    type: 'POST',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      game_instance_id: {{ $game_instance_id }}
    },
    success: function(response){ 
      $('#reward-modal-body').html(response);
      $('#rewardModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
      });
      if(response && response.message){
        $('#reward-acquired-modal-body').html(response.message);
        $('#rewardAcquiredModal').modal('show');
      }
      $('#rewardModal').modal('hide');
    }
  });

  
}


$(function () {
 
  /* Presenta cuadro de dialogo, solo si esta habilitado */
  
  if(1 == {{($gameInstance->enable_rewards == 1) ? 1 : 0}}){

    $("#dialog").dialog({
        autoOpen: true,
        closeOnEscape: false,
        draggable: false,
        modal: true,
        width: 600,
        show: "bounce",
        buttons: [
            {
                text: "Recuperar recompensa",
                icon: "ui-icon-heart",
                click: function() {


                  $.ajax({
                      type: "POST",
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      url: "/rewards/transaction/{{$game_instance_id}}/process" ,
                      dataType: 'json',
                      contentType: 'application/json',
                      data: JSON.stringify({
                          day: 1
                      })
                  })
                  .then(function(data_result){
                      /* if(data_result && data_result['result'] == 0 && data_result['url']){
                          window.location.replace(data_result['url']);
                          return;
                      }else if(data_result && data_result['result'] == 0 ){
                          renderNextSlide();
                      } */
                      $( this ).dialog( "close" );
                  });


                    $( this ).dialog( "close" );
                }
            }
        ],
        create:function () {
            $(this).closest(".ui-dialog")
                .find(".ui-button:first") // the first button
                .addClass("btn btn-primary btn-lg");
        }

    });

  } // endif rewards

});

/** Aumenta contadores de puntaje */
$('.counter').each(function () {
  var $this = $(this);
  jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
    duration: 2000,
    easing: 'swing',
    step: function () {
      $this.text(Math.ceil(this.Counter));
    }
  });
});

</script>

@endpush
