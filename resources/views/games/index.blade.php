@extends('layouts.app')

@section('content')

    <section class="content-header">
        
        <div class="pull-left">
            <h1>
                Juegos
            </h1>
            <p>
                Gestiona los juegos base para armar los experimentos.
            </p>
        </div>
        <div class="pull-right">
            <h1>
                <a class="btn btn-primary" style="margin-top: -10px;margin-bottom: 5px" href="{{ route('games.create') }}">Agregar nuevo</a>
            </h1>
        </div>  
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('games.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

