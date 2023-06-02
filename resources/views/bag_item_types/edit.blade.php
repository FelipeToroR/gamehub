@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Editar Tipo de ítem de mochila
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bagItemType, ['route' => ['bagItemTypes.update', $bagItemType->id], 'method' => 'patch']) !!}

                        @include('bag_item_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

