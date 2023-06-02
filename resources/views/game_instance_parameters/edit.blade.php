@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Parámetros de instancia de juego
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($gameInstanceParameter, ['route' => ['experiments.game-instances.parameters.update', $experiment_id, $game_instance_id, $game_instance_parameter_id], 'method' => 'patch']) !!}
                        @include('game_instance_parameters.fields_update')
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection