<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/2.0.1/tables.min.css" integrity="sha256-H9ZotRAz21WfrMoBAZHGfxNxJMmMkLE9yQtUwvDV3tw=" crossorigin="anonymous" />

<style>
h1, h2, h3, p, body {
    font-family: 'Open Sans', sans-serif;
}
</style>
<h1>GameHUB: Registro de tiempo de juego</h1>

<p>Juego educativo: <i>{{ $experiment->name }}</i></p>

@forelse ($data as $datum)

    
        
    <h2>{{ $datum['date']->format('d-m-Y') }} / {{ $daysSpanish[$datum['date']->dayOfWeek] }}</h2>

    <p>Estudiantes: {{ count($datum['data'])}}</p>

    <table class="pure-table">
        <thead>
            <tr>
                <th>Apellidos</th>
                <th>Nombres</th>
                <th>Curso</th>
                <th>Colegio</th>
                <th>Intervalo*</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($datum['data'] as $studentItem)
            <tr class="pure-table-odd">
                <td><b>{{$studentItem->first_surname}}</b> {{$studentItem->second_surname}}</td>
                <td>{{$studentItem->name}}</td>
                <td>{{$studentItem->course}} {{$studentItem->course_letter}}</td>
                <td>{{$studentItem->college}}</td>
                <td> {{\Carbon\CarbonInterval::seconds($studentItem->time)->cascade()->forHumans()}}</td>
            </tr>
            @empty
            <tr class="pure-table-odd">
                <td colspan="5">No hay registros de estudiantes para este día</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <small>
    * Intervalo corresponde a la diferencia entre el primer acceso y último acceso al juego en el dia, no es necesariamente tiempo continuo.
    </small>
    <pagebreak></pagebreak>

@empty

No hay registros este día
<pagebreak></pagebreak>
@endforelse
