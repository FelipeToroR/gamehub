@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Reward Day Item
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['rewards.days.items.store', $reward->id, $rewardDay->id]]) !!}

                        @include('reward_day_items.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
