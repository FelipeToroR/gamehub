@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User Experiment
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('user_experiments.show_fields')
                    <a href="{{ route('userExperiments.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
