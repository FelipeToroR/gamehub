{!! Form::open(['route' => ['experiments.entrypoints.destroy', $experiment_id, $token], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('experiments.entrypoints.show', [ $experiment_id, $token]) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    <a href="{{ route('experiments.entrypoints.edit', [ $experiment_id, $token]) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
