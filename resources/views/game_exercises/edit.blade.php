@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Game Exercise
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($gameExercise, ['route' => ['gameExercises.update', $gameExercise->id], 'method' => 'patch']) !!}

                        @include('game_exercises.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection