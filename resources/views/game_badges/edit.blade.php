@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Game Badge
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($gameBadge, ['route' => ['gameBadges.update', $gameBadge->id], 'method' => 'patch']) !!}

                        @include('game_badges.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection