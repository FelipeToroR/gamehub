<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $userEntrypoint->title }}</p>
</div>

<!-- Information Field -->
<div class="form-group">
    {!! Form::label('information', 'Information:') !!}
    <p>{{ $userEntrypoint->information }}</p>
</div>

<!-- Obfuscated Field -->
<div class="form-group">
    {!! Form::label('obfuscated', 'Obfuscated:') !!}
    <p>{{ $userEntrypoint->obfuscated }}</p>
</div>

<!-- User Response Field -->
<div class="form-group">
    {!! Form::label('user_response', 'User Response:') !!}
    <p>{{ $userEntrypoint->user_response }}</p>
</div>

<!-- Experiment Id Field -->
<div class="form-group">
    {!! Form::label('experiment_id', 'Experiment Id:') !!}
    <p>{{ $userEntrypoint->experiment_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $userEntrypoint->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $userEntrypoint->updated_at }}</p>
</div>

