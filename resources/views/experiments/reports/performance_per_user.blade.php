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
    <h2>{{ $datum['user']->name }}</h2>

    <table class="pure-table">
        <thead>
            <tr>
                <th>Ejercicio</th>
                <th>Respuesta de usuario</th>
                <th>Respuesta correcta</th>              
                <th>Evaluacion</th>     
            </tr>
        </thead>
        <tbody>
            @forelse ($datum['data'] as $studentItem)
            <tr class="pure-table-odd">
                <td>{{$studentItem->exercise}}</td>
                <td>{{$studentItem->user_response}}</td>
                <td>{{$studentItem->response}}</td>
                <td>{{$studentItem->solved}}</td>
            </tr>
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
