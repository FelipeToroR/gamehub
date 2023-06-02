@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Game Instance Parameter
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['experiments.game-instances.parameters.store', $experiment_id, $game_instance_id]]) !!}

                        @include('game_instance_parameters.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
