@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Instancia de juego
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($gameInstance, ['route' => ['experiments.game-instances.update', $experiment_id, $gameInstance->id], 'method' => 'patch']) !!}

                        @include('game_instances.fields_update')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection