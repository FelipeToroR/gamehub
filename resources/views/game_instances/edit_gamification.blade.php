@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Gamificación de la instancia de juego
        </h1>
        <p>
            Configura los aspectos de gamificación de esta versión de juego.
        </p>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($gameInstance, ['route' => ['experiments.game-instances.gamification.update', $experiment_id, $gameInstance->id], 'method' => 'patch']) !!}
                        @include('game_instances.fields_update_gamification')
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection