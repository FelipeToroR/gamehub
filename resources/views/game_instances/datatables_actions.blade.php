{!! Form::open(['route' => ['experiments.game-instances.destroy', $experiment_id,  $id], 'method' => 'delete']) !!}
<div class='btn-group'>

    <a href="{{ route('game-instances.play', [$game_slug, $slug, 't' => $token]) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-play"></i>
    </a>

    <a href="{{ route('experiments.game-instances.show', [$experiment_id, $slug]) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>

    <a href="{{ route('experiments.game-instances.edit', [$experiment_id, $id]) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>

    <a href="{{ route('experiments.game-instances.gamification.edit', [$experiment_id, $id]) }}" title="Configura gamificación" class='btn btn-default btn-xs'>
        <i class="fas fa-gamepad"></i>
    </a>

    <a href="{{ route('experiments.game-instances.parameters.index', [$experiment_id, $id]) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon  glyphicon-th-list"></i>
    </a>


    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}

</div>
{!! Form::close() !!}
