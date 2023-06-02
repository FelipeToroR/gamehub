@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User Bag Item
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($userBagItem, ['route' => ['userBagItems.update', $userBagItem->id], 'method' => 'patch']) !!}

                        @include('user_bag_items.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection