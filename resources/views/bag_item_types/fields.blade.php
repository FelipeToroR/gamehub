<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Descripción:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Actions Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('actions', 'Instrucciones de acción:') !!}
    {!! Form::textarea('actions', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12 col-lg-12">

<div class="alert alert-info">
<div class="row">
<div class="col-sm-6">
    <ul>
        <li><code>ADD_CURRENCY</code>: Agrega monto al usuario</li>
        <li>
            Parámetros:
            <ul>
                <li><code>value</code>: Valor para monto.</li>
            </ul>
        </li>
    </ul>
    <pre>
{
    "action": "ADD_CURRENCY",
    "value": 10
}
    </pre>
</div>
<div class="col-sm-6">
    <ul>
        <li><code>ADD_RANDOM_CURRENCY</code>: Agrega monto aleatorio al usuario entre dos valores</li>
        <li>
            Parámetros:
            <ul>
                <li><code>min</code>: Valor mínimo para monto aleatorio.</li>
                <li><code>max</code>: Valor máximo para monto aleatorio.</li>
            </ul>
        </li>
    </ul>
    <pre>
{
    "action": "ADD_RANDOM_CURRENCY",
    "min": 10,
    "max": 40
}
    </pre>
</div>
</div>
</div>
</div>
<!-- Game Id Field -->
<!-- <div class="form-group col-sm-6"> -->
    <!--{--!! Form::label('game_id', 'Juego:') !!--}-->
    <!--{--!! Form::select('game_id', $gameItems, null, ['class' => 'form-control']) !!--}-->
<!-- </div> -->

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('bagItemTypes.index') }}" class="btn btn-default">Cancelar</a>
</div>
