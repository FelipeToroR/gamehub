@if ($type == 0)
    <div class="label label-default">
        SIN ASIGNAR
    </div>
@elseif ($type == 1)
    <div class="label label-warning">
        INICIAL
    </div>
@elseif ($type == 2)
    <div class="label label-success">
        POR FECHA ({{$initial_date}} - {{$end_date}})
    </div>
@endif

