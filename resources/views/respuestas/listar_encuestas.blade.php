@extends('respuestas.index')


@section('encuestas')

    <!-- Para dejar marcado el experimento -->
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            document.querySelector('#expe').value = {{ $id }};
        });
    </script>

    
    <p>ID: {{ $id }}</p>



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
@endsection
