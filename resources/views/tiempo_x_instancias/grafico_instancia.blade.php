@extends('layouts.app')

@section('content')

    <script src = "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js"></script>
    <!--------------------- Se incluye la libreria de gráficos  -------------->

    @foreach ($users as $user)

   
    
        <div> {{$user->name }} ( {{$user->user_id}} ) 
                ID instancia : {{$user->game_instance_id}} 
                se demoro : {{$user['tiempo_total']}}
                Los dias en que jugó : {{$user['lista_fechas']}}
                Cuanto se demoró cada dia :  
                
                @foreach ($user['tiempo_por_dia'] as $t)
                   
                  {{$t}}
                @endforeach
        </div>
        
        <div></div>
        

    @endforeach


<script>
  var users = <?php echo json_encode($users); ?>;
  var nombres_usuarios = [];
  users.forEach(user => {
    nombres_usuarios.push(user.name);
  });

  var tiempos = <?php echo json_encode($tiempos); ?>;

  var promedio = <?php echo json_encode($promedio); ?>;
  const promedioArray = Array(tiempos.length).fill(promedio);
</script>

<div class="chart-container" style="width: 80%;">
  <canvas id="myChart"></canvas> 
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: nombres_usuarios,
      datasets: [{
        label: 'Minutos jugados por usario',
        data: tiempos,

        backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 159, 64, 0.5)'],
        borderWidth: 2
    },
    {
      label: 'Promedio',
      type: 'line',
      data: promedioArray,
      borderColor: 'rgba(255, 99, 132, 1)',
      borderWidth: 2,
      fill: false
    }]
  },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>




<script> 
  var dias_x_tiempo = <?php echo json_encode($dias_jugados); ?>;

  const todas_las_fechas = <?php echo json_encode($fechasCompletas); ?>;

  const tiempoJugado = new Array(todas_las_fechas.length).fill(0);

  for (var i = 0; i < todas_las_fechas.length; i++) {

    var fecha = todas_las_fechas[i];

  if (dias_x_tiempo[fecha] !== undefined) {
    tiempoJugado[i] = dias_x_tiempo[fecha];
  }

}

</script>

<div><canvas id="graficoJuegos"></canvas></div>

<div>
 <input onchange="filtrarDatos()" type="date" id="stardate" value="{{ $fecha_mas_lejana }}">
 <input onchange="filtrarDatos()" type="date" id="enddate" value="{{ $fecha_mas_reciente }}">

</div>

<script>
  
</script>

<script>

  var ctz = document.getElementById('graficoJuegos').getContext('2d');
  
  // Configuración inicial del gráfico
  var config = {
    type: 'bar',
    data: {
      labels: todas_las_fechas,

      datasets: [{
        label: 'Juegos por día',
        // Los datos se actualizarán con el filtro seleccionado
        data: tiempoJugado,
        
        
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          stepSize: 1
        }
      }
    }
  };

  var grafico = new Chart(ctz, config);

  // Función para filtrar los datos según el rango seleccionado
  function filtrarDatos(rango) {

    const dates2 = [...todas_las_fechas]; // se duplica el original

    //obtener la posicion en el array 
    const indexStartDate = dates2.indexOf(document.getElementById('stardate').value);
    const indexEndDate = dates2.indexOf(document.getElementById('enddate').value);


    // Filtrar los datos según el rango seleccionado
    const fechasFiltradas = dates2.slice(indexStartDate, indexEndDate + 1);

    // Actualizar los datos del gráfico con los datos filtrados
    grafico.config.data.labels = fechasFiltradas;


    // Actualizar dataPoints
    const dataPoints2 = [...tiempoJugado]; // solo arreglos simples, no nested
    const dataPointsFiltrados = dataPoints2.slice(indexStartDate, indexEndDate + 1); 

    grafico.config.data.datasets[0].data = dataPointsFiltrados;

    grafico.update();
  }
</script>


    

@endsection
