@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Reward Day
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($rewardDay, ['route' => ['rewards.days.update', $reward->id, $rewardDay->id], 'method' => 'patch']) !!}

                        @include('reward_days.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection