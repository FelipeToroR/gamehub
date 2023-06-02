{!! Form::open(['route' => ['games.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can('games.show')
    <a href="{{ route('games.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    @endcan
    @can('games.edit')
    <a href="{{ route('games.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    @endcan
    @can('games.edit')
    <a href="{{ route('games.parameters.index', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-th-list"></i>
    </a>
    @endcan

    <a href="{{ route('games.badges.index', $id) }}" title="Medallas" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-certificate"></i>
    </a>
    
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
