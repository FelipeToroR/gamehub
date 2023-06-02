@extends('layouts.frontend.app')

@section('content')

<div class="header pt-5">
  <div class="header bg-transparent bg-cloudxx" style="height: 100%">
    <div class="container">
      <div class="row">
      @foreach ($game_instances_user_list as $game_instance)
      <div class="col-md-4">
      <div class="card mb-3">
        <img class="card-img-top img-fluid" data-src="holder.js/100px180/" alt="100%x150" src="\assets\gamification\bg-game-default.jpg" data-holder-rendered="true" >
        <div class="card-body p-2 ">
          <b class="card-title p-0 m-0">{{ $game_instance->name}}</b>
        </div>
        <div class="card-footer p-2">

          @if(1 == 0)
        <a class="btn btn-lg btn-disabled btn-block" >
          Bloqueado
        </a>
        @elseif(1 == 1)
        <a class="btn btn-lg btn-success btn-block" href="{{ route('dashboard.experiment', [$game_instance->experiment_id]) }}">
          ¡ Jugar ahora !
        </a>
        @elseif(1 == 2)
        <a class="btn btn-lg btn-danger btn-block" >
          Finalizado
        </a>
        @endif
        </div>
      </div>
      </div>
      
      <!-- 
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
          <div class="thumbnail">
              <a href="#" title="Visit design">
                  <img alt="" class="img-responsive" src="\assets\gamification\bg-game-default.jpg">
              </a>
              <h3>
              <a href="#" title="Title goes here">{{ $game_instance->name}}</a><br>
              </h3>
              <div class="stats">
                  
              </div>

          <a href="" class="btn btn-primary btn-block btn-lg">Jugar ahora</a>

          </div>
      </div> -->
      @endforeach
      </div>
    </div>
  </div>
@endsection