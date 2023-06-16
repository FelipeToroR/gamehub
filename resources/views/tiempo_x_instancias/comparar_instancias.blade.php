@extends('layouts.app')

@section('content')

@foreach ($colegios as $col)

<div>{{$col}}</div>  
@endforeach

<div>
    Alumno(a)s de : 
@foreach ($cursos as $c)

<div>{{$c}}</div>  
@endforeach

<!--</div>

@foreach ($tiempo_total_cada_instancia as $nombre => $tt)

<div>nombre : {{$nombre}} Tiempo : {{$tt}}</div>  
@endforeach -->

<h3>Comparación de minutos jugados</h3>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="torta-container" style="width: 30%;"><canvas id="graficoTorta"></canvas></div>

    <script>
        // Obtén los datos del controlador
        var data = <?php echo json_encode($tiempo_total_cada_instancia); ?>;

        // Prepara los datos para Chart.js
        var labels = Object.keys(data);
        var values = Object.values(data);

        // Configura el gráfico
        var ctx = document.getElementById('graficoTorta').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',   // Azul 
                            'rgba(255, 99, 132, 0.7)',   // Rojo
                            'rgba(255, 206, 86, 0.7)',   // Amarillo 
                            'rgba(75, 192, 192, 0.7)',   // Verde 
                            'rgba(153, 102, 255, 0.7)',  // Violeta 
                            'rgba(255, 159, 64, 0.7)',   // Naranja 
                            'rgba(0, 204, 102, 0.7)',    // Verde azulado 
                            'rgba(255, 0, 255, 0.7)',    // Magenta
                            'rgba(128, 128, 128, 0.7)',  // Gris
                            'rgba(0, 102, 204, 0.7)'     // Azul oscuro
                    ]
                }]
            }
        });
    </script>


<div class="lineas-container" style="width: 90%;"><canvas id="horas_jugadas"></canvas></div>

<script>

var datosPorHora = {!! json_encode($datosPorHora) !!};

console.log(datosPorHora);

var etiquetas = ['1 am','2 am','3 am','4 am','5 am','6 am','7 am','8 am','9 am','10 am','11 am','12 pm','1 pm','2 pm','3 pm','4 pm','5 pm','6 pm','7 pm','8 pm','9 pm','10 pm','11 pm', '12 am'];
var datasets = [];

Object.keys(datosPorHora).forEach(function(grupo) {
    var data = etiquetas.map(function(hora) {
      return datosPorHora[grupo][hora] || 0; // Si no hay datos para la hora, asignamos 0
    });

    var dataset = {
      label: grupo,
      data: data,
      fill: false
    };

    datasets.push(dataset);
  });


</script>

<script>
    const config = {
  type: 'line',
  data: {
    labels: etiquetas,
    datasets: datasets
  },
  options: {
    responsive: true,
    scales: {
      x: {
        display: true,
        title: {
          display: true,
          text: 'Hora'
        }
      },
      y: {
        display: true,
        title: {
          display: true,
          text: 'Horas Jugadas'
        }
      }
    }
  }
};


const ctz = document.getElementById('horas_jugadas').getContext('2d');
new Chart(ctz, config);
</script>



@endsection