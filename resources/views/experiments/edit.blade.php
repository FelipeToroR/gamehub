@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Editar Experimento
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($experiment, ['route' => ['experiments.update', $experiment->id], 'method' => 'patch']) !!}

                        @include('experiments.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection