@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User Experiment
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    @include('flash::message')
                    {!! Form::open(['route' => ['experiments.users.store', $experiment_id]]) !!}

                        @include('user_experiments.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
