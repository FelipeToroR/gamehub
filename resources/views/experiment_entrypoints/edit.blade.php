@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Experiment Entrypoint
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($experimentEntrypoint, ['route' => ['experiments.entrypoints.update', $experiment_id,  $experimentEntrypoint->token ], 'method' => 'patch']) !!}
                        @include('experiment_entrypoints.fields')
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection