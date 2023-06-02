<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $experimentEntrypoint->title }}</p>
</div>

<!-- Information Field -->
<div class="form-group">
    {!! Form::label('information', 'Information:') !!}
    <p>{{ $experimentEntrypoint->information }}</p>
</div>

<!-- Obfuscated Field -->
<div class="form-group">
    {!! Form::label('obfuscated', 'Obfuscated:') !!}
    <p>{{ $experimentEntrypoint->obfuscated }}</p>
</div>

<!-- Experiment Id Field -->
<div class="form-group">
    {!! Form::label('experiment_id', 'Experiment Id:') !!}
    <p>{{ $experimentEntrypoint->experiment_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $experimentEntrypoint->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $experimentEntrypoint->updated_at }}</p>
</div>

