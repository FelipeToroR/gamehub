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
                   {!! Form::model($rewardDayItem, ['route' => ['rewardDayItems.update', $rewardDayItem->id], 'method' => 'patch']) !!}

                        @include('reward_day_items.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection