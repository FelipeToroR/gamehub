<!-- Name Field -->
<div class="form-group col-sm-8">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-4">
    {!! Form::label('status', 'Estado:') !!}
    {!! Form::select('status', ['0' => 'Detenido', '1' => 'En ejecución'], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('time_limit', 'Tiempo límite diario (segundos):') !!}
    {!! Form::number('time_limit', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Descripción:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('experiments.index') }}" class="btn btn-default">Cancelar</a>
</div>
