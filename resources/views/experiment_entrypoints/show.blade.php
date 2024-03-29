@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Experiment Entrypoint
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('experiment_entrypoints.show_fields')
                    <a href="{{ route('experiments.entrypoints.index', $experiment_id) }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
