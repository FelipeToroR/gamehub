
<div class="form-group">
    {!! Form::label('name', 'Variable:') !!}
    <p>{{ $gameInstanceParameter->gameParameter->name }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Valor:') !!}
    <p>{{ $gameInstanceParameter->name }} ({{ $gameInstanceParameter->gameParameter->type }})</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $gameInstanceParameter->description }}</p>
</div>

<!-- Game Instance Id Field -->
<div class="form-group">
    {!! Form::label('game_instance_id', 'Game Instance Id:') !!}
    <p>{{ $gameInstanceParameter->game_instance_id }}</p>
</div>

<!-- Game Parameter Id Field -->
<div class="form-group">
    {!! Form::label('game_parameter_id', 'Game Parameter Id:') !!}
    <p>{{ $gameInstanceParameter->game_parameter_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $gameInstanceParameter->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $gameInstanceParameter->updated_at }}</p>
</div>

