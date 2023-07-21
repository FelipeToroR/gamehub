<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Conditions Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('conditions', 'Conditions:') !!}
    {!! Form::textarea('conditions', null, ['class' => 'form-control']) !!}
</div>

<!-- Game Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('game_id', 'Game Id:') !!}
    {!! Form::select('game_id', $gameItems, $game_id, ['class' => 'form-control', 'disabled']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('game_badges.index', ['game_id' => $game_id]) }}" class="btn btn-default">Cancel</a>
</div>
