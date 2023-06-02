<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $bagItemType->name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $bagItemType->description }}</p>
</div>

<!-- Actions Field -->
<div class="form-group">
    {!! Form::label('actions', 'Actions:') !!}
    <p>{{ $bagItemType->actions }}</p>
</div>

<!-- Game Id Field -->
<div class="form-group">
    {!! Form::label('game_id', 'Game Id:') !!}
    <p>{{ $bagItemType->game_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $bagItemType->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $bagItemType->updated_at }}</p>
</div>

