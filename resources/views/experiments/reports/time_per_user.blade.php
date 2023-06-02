<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/2.0.1/tables.min.css" integrity="sha256-H9ZotRAz21WfrMoBAZHGfxNxJMmMkLE9yQtUwvDV3tw=" crossorigin="anonymous" />

<style>
    body{
        font-size: 12px;
    }
h1, h2, h3, p, body {
    font-family: 'Open Sans', sans-serif;
    
}


</style>
<h2>GameHUB: Registro de partidas por usuario por tiempo</h2>

<p>Juego educativo: <i>{{ $experiment->name }}</i></p>

@forelse ($data as $datum)        
    <h2>{{ $datum['date']->format('d-m-Y') }} / {{ $daysSpanish[$datum['date']->dayOfWeek] }}</h2>

    <p>Estudiantes: {{ count($datum['data'])}}</p>

    <table class="pure-table">
        <thead>
            <tr>
                <th>Apellidos</th>
                <th>Nombres<br/>(Partida)</th>
                <th>Curso <br/> (Registro de tiempo)</th>
                <th>Colegio<br/>(Tiempo relativo)</th>
              
            </tr>
        </thead>
        <tbody>
            @forelse ($datum['data'] as $studentItem)
            <tr class="pure-table-odd">
                <td><b>{{$studentItem['user']->first_surname}}</b> {{$studentItem['user']->second_surname}}</td>
                <td>{{$studentItem['user']->name}}</td>
                <td>{{$studentItem['user']->course}} {{$studentItem['user']->course_letter}}</td>
                <td>{{$studentItem['user']->college}}</td>
            </tr>


    
            @forelse ($studentItem['data'] as $eventItem)
                <tr>
                    <td></td>
                    <td>
                        @if(isset($eventItem['event']) && $eventItem['event'] == 1)
                        Partida
                        @endif
                    
                    </td>
                    <td>{{$eventItem['time_record']}}</td>
                    <td>
                        @if(isset($eventItem['diff']))
                        {{$eventItem['diff']}}
                        @endif
                    </td>
                </tr>
            @empty
                <tr class="pure-table-odd">
                    <td colspan="3">No hay registros de estudiantes para este día</td>
                </tr>
            @endforelse
<!--
<tr>
<td colspan="3">Tiempo de efectivo de juego: </td>
<td>99</td>
</tr>
-->
            

            @empty
            <tr class="pure-table-odd">
                <td colspan="5">No hay registros de estudiantes para este día</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    


@empty

No hay registros este día
<!-- <pagebreak></pagebreak> -->
@endforelse
