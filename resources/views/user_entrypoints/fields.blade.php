<!-- User Response Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_response', 'User Response:') !!}
    {!! Form::text('user_response', null, ['class' => 'form-control']) !!}
</div>

<!-- Experiment Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('experiment_id', 'Experiment Id:') !!}
    {!! Form::select('experiment_id', $experimentItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('userEntrypoints.index') }}" class="btn btn-default">Cancel</a>
</div>
