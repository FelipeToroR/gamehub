@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Juegos
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($game, ['route' => ['games.update', $game->id],  'files' => 'true', 'method' => 'patch']) !!}

                        @include('games.fields_update')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection