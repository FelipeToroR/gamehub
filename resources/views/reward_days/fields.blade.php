<!-- Day Field -->
<div class="form-group col-sm-6">
    {!! Form::label('day', 'Día de evento:') !!}
    {!! Form::text('day', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('rewards.days.index', $reward->id) }}" class="btn btn-default">Cancelar</a>
</div>
