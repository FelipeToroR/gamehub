@extends('layouts.app')

@section('content')

    <script src = "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js"></script>
    <!--------------------- Se incluye la libreria de gráficos  -------------->

    @foreach ($users as $user)

   
    
        <div> {{$user->name }} ( {{$user->user_id}} ) ID instancia : {{$user->game_instance_id}} se demoro : {{$user['tiempo_total']}}</div>
        <div></div>
        

    @endforeach

    @foreach ($fechas as $f)
    <div>{{$f}}</div>

    @endforeach


    <script>
  var tiempos = <?php echo json_encode($tiempos); ?>;
</script>

        <div> Tiempo total usado fue : {{$Tprom}} </div>
        <div></div>
        
    
        <div>
        <canvas id="myChart"></canvas>
        </div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        //data: [12, 19, 3, 5, 2, 3],
        data: tiempos,

        borderWidth: 1
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



<canvas id="graficoJuegos"></canvas>
<div>
 <input onchange="filtrarDatos()" type="date" id="stardate" value="2021-08-25">
 <input onchange="filtrarDatos()" type="date" id="enddate" value="2021-08-31">

</div>

<script>
  var fechas = <?php echo json_encode($fechas); ?>;
</script>

<script>
  //var fechas = {!! json_encode($fechas) !!};

  //const ctz = document.getElementById('graficoJuegos');
  var ctz = document.getElementById('graficoJuegos').getContext('2d');
  
  const dates = ['2021-08-25','2021-08-26','2021-08-27','2021-08-28','2021-08-29', '2021-08-30', '2021-08-31'];
  const dataPoints = [1, 2 , 3 , 4 , 5 , 6,  7 ];
  // Configuración inicial del gráfico
  var config = {
    type: 'bar',
    data: {
      //labels: fechas,
      labels: dates,

      datasets: [{
        label: 'Juegos por día',
        // Los datos se actualizarán con el filtro seleccionado
        data: dataPoints,
        borderWidth: 1
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

    const dates2 = [...dates]; // se duplica el original
    //console.log(dates2);

    
    const fechaInicio =  document.getElementById('stardate');
    const fechaFin = document.getElementById('enddate');

    //obtener la posicion en el array 
    const indexStartDate = dates2.indexOf(fechaInicio.value);
    const indexEndDate = dates2.indexOf(fechaFin.value);

    console.log(indexEndDate);

    // Filtrar los datos según el rango seleccionado
    const fechasFiltradas = dates2.slice(indexStartDate, indexEndDate + 1);

    // Actualizar los datos del gráfico con los datos filtrados
    grafico.config.data.labels = fechasFiltradas;


    // Actualizar dataPoints
    const dataPoints2 = [...dataPoints]; // solo arreglos simples, no nested
    const dataPointsFiltrados = dataPoints2.slice(indexStartDate, indexEndDate + 1); 

    grafico.config.data.datasets[0].data = dataPointsFiltrados;

    grafico.update();
  }
</script>


    

@endsection
