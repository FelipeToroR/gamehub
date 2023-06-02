@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Medallas del juego
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    
                    @include('game_badges.show_fields')
                    <a href="{{ route('games.badges.index', $game_id) }}" class="btn btn-default">Atrás</a>
                
                </div>
            </div>
        </div>
    </div>
@endsection
