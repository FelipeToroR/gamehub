<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<div class="form-group col-sm-12 col-lg-12">
<hr/>
</div>

<!-- Gráfico de avance personal  -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::checkbox('enable_rewards', 1) !!}&nbsp;
    {!! Form::label('reward_id', 'Recompensas por inicio de sesión') !!}
    {!! Form::select('reward_id', $rewardItems, null, ['class' => 'form-control']) !!}
    <small>Las recompensas de inicio de sesión permiten acumular monedas a lo largo del tiempo.</small>
</div>

<!-- Gráfico de avance personal  -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::checkbox('enable_performance_chart', 1) !!}&nbsp;
    {!! Form::label('enable_performance_chart', 'Gráfico de rendimiento de usuario') !!}
    <br/>
    <small>El gráfico de rendimiento de usuario presenta un gráfico con los últimos 10 puntajes en el juego.</small>
</div>

<!-- Panel de medallas en dashboard  -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::checkbox('enable_badges', 1) !!}&nbsp;
    {!! Form::label('enable_badges', 'Panel de medallas') !!}
    <br/>
    <small>El panel de medallas de usuario se despliega en el dashboard del experimento.</small>
</div>

<!-- Panel de medallas en dashboard  -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::checkbox('enable_leaderboard', 1) !!}&nbsp;
    {!! Form::label('enable_leaderboard', 'Ranking de juego') !!}
    <br/>
    <small>El ranking de puntajes mayores se despliega bajo el juego y registra los <i>records</i> de puntaje.</small>
</div>

<hr/>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('experiments.game-instances.index', $experiment_id) }}" class="btn btn-default">Cancelar</a>
</div>
