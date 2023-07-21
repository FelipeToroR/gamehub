@extends('respuestas.index')


@section('encuestas')

    <!-- Para dejar marcado el experimento -->
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            document.querySelector('#expe').value = {{ $id }};
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <canvas id="radarChart"></canvas>

    <script>
        // Obtener los datos del arreglo PHP
        var groupPercentages = <?php echo json_encode($groupPercentages); ?>;
      
        // Obtener las claves del primer grupo como etiquetas para el gráfico
        var groups = Object.keys(groupPercentages);
        var labels = Object.keys(groupPercentages[groups[0]]);
        
        // Crear un arreglo de valores para cada grupo
        var datasets = [];
        var groups = Object.keys(groupPercentages);
        groups.forEach(function(group, index) {
            var values = Object.values(groupPercentages[group]);
            datasets.push({
                label: group,
                data: values,
                borderWidth: 1 // Puedes ajustar el ancho del borde según tus preferencias
            });
        });
        
        // Crear el gráfico radar
        var ctx = document.getElementById('radarChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                scale: {
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: 4,
                        stepSize: 1
                    }
                }
            }
        });
    </script>


<head>
    <title>Gráfico Polar</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <canvas id="myChart"></canvas>
    <script>
        var groupPercentages = @json($groupPercentages);
        
        var labels = ['Actitud y disfrute', 'Preparación y habilidad', 'Motivación y propósito', 'Esfuerzo y compromiso',
                      'Emociones y ansiedad', 'Valor y utilidad', 'Obligación y falta de opciones', 'Importancia'];
        var dataPasivo = [];
        var dataActivo = [];

          // Colores personalizados para cada categoría
          var backgroundColors = [
            'rgba(255, 99, 132, 0.2)',   // Actitud y disfrute
            'rgba(54, 162, 235, 0.2)',   // Preparación y habilidad
            'rgba(255, 206, 86, 0.2)',    // Motivación y propósito
            'rgba(75, 192, 192, 0.2)',    // Esfuerzo y compromiso
            'rgba(153, 102, 255, 0.2)',   // Emociones y ansiedad
            'rgba(255, 159, 64, 0.2)',    // Valor y utilidad
            'rgba(255, 0, 255, 0.2)',     // Obligación y falta de opciones
            'rgba(0, 255, 0, 0.2)'        // Importancia
        ];
        
        // Obtener los valores correspondientes a cada categoría
        for (var groupName in groupPercentages) {
            if (groupPercentages.hasOwnProperty(groupName)) {
                var categorias = groupPercentages[groupName];
                
                var data = [];
                
                for (var i = 0; i < labels.length; i++) {
                    var categoria = labels[i];
                    var valor = 0;
                    
                    // Verificar si la categoría existe en el grupo actual
                    if (categorias.hasOwnProperty('pre_imi_' + categoria.toLowerCase().charAt(0))) {
                        valor = categorias['pre_imi_' + categoria.toLowerCase().charAt(0)];
                    }
                    
                    data.push(valor);
                }
                
                if (groupName === "BLK Dropper (Pasivo)") {
                    dataPasivo = data;
                } else if (groupName === "BLK Dropper (Activo)") {
                    dataActivo = data;
                }
            }
        }
        
        var ctz = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctz, {
            type: 'polarArea',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pasivo',
                    data: dataPasivo,
                    //backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    backgroundColor: backgroundColors,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Activo',
                    data: dataActivo,
                    //backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    backgroundColor: backgroundColors,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scale: {
                    ticks: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
@endsection
