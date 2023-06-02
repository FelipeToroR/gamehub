{!! Form::open(['route' => ['experiments.game-instances.parameters.destroy', $experiment_id, $game_instance_id, $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('experiments.game-instances.parameters.show', [$experiment_id,$game_instance_id, $id]) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    <a href="{{ route('experiments.game-instances.parameters.edit', [$experiment_id,$game_instance_id, $id]) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!} 
