@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Bag Item Type
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('bag_item_types.show_fields')
                    <a href="{{ route('bagItemTypes.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
