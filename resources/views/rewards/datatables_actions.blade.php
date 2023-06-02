{!! Form::open(['route' => ['rewards.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('rewards.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    <a href="{{ route('rewards.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    <a href="{{ route('rewards.days.index', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-align-justify"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
