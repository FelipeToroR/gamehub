@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Carga masiva de usuarios
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'users.store-batch', 'files' => 'true']) !!}
                        <div class="form-group col-sm-6">
                            {!! Form::label('user_file', 'Archivo de carga:') !!}
                            {!! Form::file('user_file') !!}
                        </div>
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Cargar', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ route('users.index') }}" class="btn btn-default">Cancelar</a>
                        </div>
                    {!! Form::close() !!}
                </div>
                <div class="row">
                    @isset($failures)
                        <div class="col-lg">
                            <p>Se encontraron algunos problemas con su archivo:</strong>    
                            @foreach ($failures as $failure)
                                <div class="callout callout-danger" style="margin: 0 20px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Fila {{$failure->row()}} en atributo {{$failure->attribute()}}</h4>
                                    <ul>
                                    @foreach ($failure->errors() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                    <li>
                                        @if(isset($failure->values()[$failure->attribute()]))
                                        {{ $failure->values()[$failure->attribute()] }}
                                        @endif
                                    </li>
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
