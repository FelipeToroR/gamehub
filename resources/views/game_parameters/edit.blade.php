@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Game Parameter
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($gameParameter, ['route' => ['games.parameters.update', $game_id, $gameParameter->id], 'method' => 'patch']) !!}

                        @include('game_parameters.fields_update')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection