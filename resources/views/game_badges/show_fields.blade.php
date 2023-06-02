<!-- Name Field -->
<div class="form-group">
    {!! Form::label('image', 'Imagen:') !!}
    <img src="/badges/{{ $gameBadge->id }}/image" />
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $gameBadge->name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $gameBadge->description }}</p>
</div>

<!-- Conditions Field -->
<div class="form-group">
    {!! Form::label('conditions', 'Conditions:') !!}
    <p>{{ $gameBadge->conditions }}</p>
</div>

<!-- Game Id Field -->
<div class="form-group">
    {!! Form::label('game_id', 'Game Id:') !!}
    <p>{{ $gameBadge->game_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $gameBadge->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $gameBadge->updated_at }}</p>
</div>

