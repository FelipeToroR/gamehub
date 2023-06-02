@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Parámetros de instancia de juego
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('game_instance_parameters.show_fields')
                    <a href="{{ route('experiments.game-instances.parameters.index', [$experiment_id, $id]) }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
