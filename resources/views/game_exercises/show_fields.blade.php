<!-- Exercise Field -->
<div class="form-group">
    {!! Form::label('exercise', 'Exercise:') !!}
    <p>{{ $gameExercise->exercise }}</p>
</div>

<!-- User Response Field -->
<div class="form-group">
    {!! Form::label('user_response', 'User Response:') !!}
    <p>{{ $gameExercise->user_response }}</p>
</div>

<!-- Response Field -->
<div class="form-group">
    {!! Form::label('response', 'Response:') !!}
    <p>{{ $gameExercise->response }}</p>
</div>

<!-- Extra Field -->
<div class="form-group">
    {!! Form::label('extra', 'Extra:') !!}
    <p>{{ $gameExercise->extra }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $gameExercise->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $gameExercise->updated_at }}</p>
</div>

