<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $gameInstance->name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $gameInstance->description }}</p>
</div>

{!! Form::label('parameters', 'Parametros de configuración de instancia:') !!}
<pre>{{ $params }}</pre>

<!-- Game Id Field -->
<div class="form-group">
    {!! Form::label('game_id', 'Game Id:') !!}
    <p>{{ $gameInstance->game_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $gameInstance->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $gameInstance->updated_at }}</p>
</div>

