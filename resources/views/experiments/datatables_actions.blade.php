{!! Form::open(['route' => ['experiments.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('experiments.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>&nbsp;Editar
    </a>
    <a href="{{ route('experiments.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-info-sign"></i>&nbsp;Configurar
    </a>
    
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('¿Estas seguro que ?')"
    ]) !!} 
</div>

{!! Form::close() !!}
