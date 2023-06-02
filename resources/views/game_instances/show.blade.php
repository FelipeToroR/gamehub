@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Game Instance
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('game_instances.show_fields')
                    <a href="{{ route('experiments.game-instances.index', $experiment_id) }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
