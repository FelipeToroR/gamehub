<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::select('user_id', $userItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Experiment Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('experiment_id', 'Experiment Id:') !!}
    {!! Form::select('experiment_id', $experimentItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Enabled Field -->
<div class="form-group col-sm-6">
    {!! Form::label('enabled', 'Enabled:') !!}
    {!! Form::select('enabled', ['1' => 'Activo', '0' => 'Inactivo'], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('experiments.users.index', $experiment_id) }}" class="btn btn-default">Cancel</a>
</div>
