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
                    {!! Form::open(['route' => ['games.badges.store', 'game' => $game_id] ]) !!}

                        @include('game_badges.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
