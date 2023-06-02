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

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-3">
    {!! Form::radio('type', 0, ['class' => 'form-control']) !!}
    {!! Form::label('type', 'Sin asignar') !!}
    <p>
        Sin asignar
    </p>
</div>

<div class="form-group col-sm-12 col-lg-3">
    {!! Form::radio('type', 1, ['class' => 'form-control']) !!}
    {!! Form::label('type', 'Inicial') !!}
    <p>
        Selecciona esta opción si la encuesta se realiza al inicio del juego.
    </p>
</div>

<div class="form-group col-sm-12 col-lg-3">
    {!! Form::radio('type', 3, ['class' => 'form-control']) !!}
    {!! Form::label('type', 'Por respuestas') !!}
    <p>
        Selecciona esta opción si la encuesta requiere de un número de respuestas para presentarse.<br>
		  0 : Al entrar nuevamente al juego<br>
		> 1 : Al completar ejercicios. Requiere reinicio desde el juego.
    </p>
    <div class="row">
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('responses_expected', 'Respuestas esperadas' ) !!}
            {!! Form::text('responses_expected', null, ['class' => 'form-control']) !!}  
        </div>
	</div>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-3">
    {!! Form::radio('type', 2, ['class' => 'form-control']) !!}
    {!! Form::label('type', 'Por tiempo') !!}
    <p>
        Selecciona esta opción si la encuesta se ejecutará en una fecha específica.
    </p>

    <div class="row">
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('initial_date', 'Fecha de inicio' ) !!}
            {!! Form::date('initial_date', null, ['class' => 'form-control']) !!}  
        </div>

        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('end_date', 'Fecha de término') !!}
            {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
        </div>

    </div>

</div>
<div class="form-group offset-sm-2 offset-lg-4 col-sm-8 col-lg-4">
    {!! Form::radio('type', 4, ['class' => 'form-control']) !!}
    {!! Form::label('type', 'Por Tiempo y Respuestas') !!}
    <p>
        Utilizar esta opción si se requiere que un test se ejecute, ya sea en un momento definido o al alcanzar una cuota de respuestas.
    </p>
</div>
<!-- Body Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('body', 'Cuerpo JSON (Recuerda revisar la estructura):') !!}
    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('experiments.surveys.index', $experiment_id) }}" class="btn btn-default">Cancel</a>
</div>
