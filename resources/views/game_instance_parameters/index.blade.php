@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Editar parámetros de instancia de juego</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('adminlte-templates::common.errors')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="rowx">
                    {!! Form::open(['route' => ['experiments.game-instances.parameters.update', $experiment_id, $game_instance_id], 'method' => 'put']) !!}



                        @foreach ($list_parameters as $item_parameter)
                        
                        <!-- Description Field -->
                        <div class="form-group row">
                            <p class="col-sm-1" style="text-align: right">
                               
                                
                                <label >{!! Form::label('a', $item_parameter->name) !!} ({{ $item_parameter->type }})</label></p>
                            <div class="col-sm-4 ">
                            

                            @switch($item_parameter->type)
                                @case('decimal')
                                    {!! Form::number('params['.$item_parameter->name.'][value]', $item_parameter->value, ['class' => 'form-control', 'step' => 'any']) !!}
                                    @break
                                @case('int')
                                    {!! Form::number('params['.$item_parameter->name.'][value]', $item_parameter->value, ['class' => 'form-control']) !!}
                                    @break
                                @case('string')
                                    {!! Form::text('params['.$item_parameter->name.'][value]', $item_parameter->value, ['class' => 'form-control']) !!}
                                    @break
                                @case('boolean')
                                    {!! Form::select('params['.$item_parameter->name.'][value]', ['true' => 'Verdadero', 'false' => 'Falso'], $item_parameter->value, ['class' => 'form-control']) !!}
                                    @break
                                @default
                                    Tipo de parámetro no admitido
                            @endswitch

                            {!! Form::hidden('params['.$item_parameter->name.'][parameter_id]', $item_parameter->gp_id) !!}
                            
                            </div>
                            <p class="col-sm-6">
                                
                                <!-- gp_id: {{ $item_parameter->gp_id}} - name: {{ $item_parameter->name}} - type: {{ $item_parameter->type}} - type: {{ $item_parameter->gip_id}}- value: {{ $item_parameter->value}}  -->
                                {{  $item_parameter->description }}
                            </p>
                        </div>
                        @endforeach


                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ route('experiments.game-instances.index',[$experiment_id] ) }}" class="btn btn-default">Cancelar</a>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

