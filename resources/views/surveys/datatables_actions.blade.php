{!! Form::open(['route' => ['experiments.surveys.destroy', $experiment_id, $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('experiments.surveys.show',  [$experiment_id, $id]) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    <a href="{{ route('experiments.surveys.edit',  [$experiment_id, $id]) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
