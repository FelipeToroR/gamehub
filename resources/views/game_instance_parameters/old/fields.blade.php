<!-- Game Parameter Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('game_parameter_id', 'Variable:') !!}
    {!! Form::select('game_parameter_id', $gameParameterItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Valor de variable:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    <br/>
    <div id="message-fullscreen" style="" class="callout callout-info">
        <h4>¡Cuidado con los tipos de dato!</h4>
        <p>Debes respetar los tipos de las variables (en próximas versiones validaremos eso)</a></p>
      </div>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>





<!-- Game Parameter Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('game_instance_id', 'Game instance:') !!}
    {!! Form::text('game_instance_id', $game_instance_id, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
</div>

<!-- Game Parameter Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('game_id', 'Game:') !!}
    {!! Form::text('game_id', $game->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('experiments.game-instances.parameters.index', [$experiment_id, $game_instance_id]) }}" class="btn btn-default">Cancelar</a>
</div>
