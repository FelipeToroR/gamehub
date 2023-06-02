@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="pull-left">
            <h1>
            Tipo de ítem de mochila
            </h1>
            <p>
                Los tipos de ítemes que se manejan en la plataforma.
            </p>
        </div>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ route('bagItemTypes.create') }}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('bag_item_types.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

