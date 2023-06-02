
<div class="form-group col-sm-8">
    {!! Form::label('token', 'Token:') !!}
    {!! Form::text('token', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-8">
    {!! Form::label('title', 'Título:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-8">
    {!! Form::label('information', 'Información:') !!}
    {!! Form::text('information', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-4">
    {!! Form::label('obfuscated', '¿Obfuscado?:') !!}
    {!! Form::select('obfuscated', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-8">
    {!! Form::label('default_course', 'Curso (por defecto):') !!}
    {!! Form::select('default_course', array(
        'Enseñanza básica' => [
            'PRIMERO BÁSICO' => '1° básico',
            'SEGUNDO BÁSICO' => '2° básico',
            'TERCERO BÁSICO' => '3° básico',
            'CUARTO BÁSICO' => '4° básico',
            'QUINTO BÁSICO' => '5° básico',
            'SEXTO BÁSICO' => '6° básico',
            'SEPTIMO BÁSICO' => '7° básico',
            'OCTAVO BÁSICO' => '8° básico',
        ]), null, ['class' => 'form-control', 'placeholder' => 'Curso']) !!}
</div>

<div class="form-group col-sm-8">
    {!! Form::label('default_college', 'Colegio (por defecto):') !!}
    {!! Form::text('default_college', null, ['class' => 'form-control']) !!}
</div>


@if(!empty($experimentEntrypoint))
<div class="form-group col-sm-4">
    {!! Form::label('url', 'URL') !!}
    {!! Form::text('url', route('register.code', $experimentEntrypoint->token), ['class' => 'form-control', 'readonly' => 'readonly']) !!}
    <!-- <a href="{{ route('register.code', $experimentEntrypoint->token) }}" target="_blank" class="btn btn-default">Ir a URL</a> -->
</div>
@endif


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('experiments.entrypoints.index', $experiment_id) }}" class="btn btn-default">Cancelar</a>
</div>
