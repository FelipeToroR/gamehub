@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Game Parameter
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('game_parameters.show_fields')
                    <a href="{{ route('games.parameters.index', $game_id) }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
