<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $userExperiment->user_id }}</p>
</div>

<!-- Experiment Id Field -->
<div class="form-group">
    {!! Form::label('experiment_id', 'Experiment Id:') !!}
    <p>{{ $userExperiment->experiment_id }}</p>
</div>

<!-- Enabled Field -->
<div class="form-group">
    {!! Form::label('enabled', 'Enabled:') !!}
    <p>{{ $userExperiment->enabled }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $userExperiment->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $userExperiment->updated_at }}</p>
</div>

