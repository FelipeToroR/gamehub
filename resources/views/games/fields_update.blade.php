<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Descripción:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Upload game Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('gamefile', 'Archivo de juego de Gamemaker 2 (.zip)') !!}
    {!! Form::file('gamefile', null, ['class' => 'form-control']) !!}
    <small><b>Atención</b>: Reemplazará la versión anterior del juego.</small>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('games.index') }}" class="btn btn-default">Cancel</a>
</div>
