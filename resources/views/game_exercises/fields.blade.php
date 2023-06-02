<!-- Exercise Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('exercise', 'Exercise:') !!}
    {!! Form::textarea('exercise', null, ['class' => 'form-control']) !!}
</div>

<!-- User Response Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_response', 'User Response:') !!}
    {!! Form::text('user_response', null, ['class' => 'form-control']) !!}
</div>

<!-- Response Field -->
<div class="form-group col-sm-6">
    {!! Form::label('response', 'Response:') !!}
    {!! Form::text('response', null, ['class' => 'form-control']) !!}
</div>

<!-- Extra Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('extra', 'Extra:') !!}
    {!! Form::textarea('extra', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('gameExercises.index') }}" class="btn btn-default">Cancel</a>
</div>
