<canvas id="bar-chart"></canvas>

<!-- Incluye la biblioteca de Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
        // Obtener los datos pasados desde el controlador
        var groupsData = {!! json_encode($groupsData) !!};

        // Crear un array para almacenar las etiquetas de las barras
        var labels = [];

        // Crear un array para almacenar los datos de cada columna
        var datasets = [];

        // Recorrer los datos de los grupos
        groupsData.forEach(function(group) {
            // Agregar la etiqueta del grupo al array de etiquetas
            labels.push(group.groupName);

            // Recorrer los datos de cada columna del grupo
            group.data.forEach(function(column, index) {
                // Verificar si ya existe un dataset para la columna actual
                var dataset = datasets.find(function(ds) {
                    return ds.label === column.label;
                });

                // Si no existe, crear un nuevo dataset para la columna actual
                if (!dataset) {
                    dataset = {
                        label: column.label,
                        data: [],
                        backgroundColor: getRandomColor() // Función para obtener un color aleatorio
                    };

                    // Agregar el dataset al array de datasets
                    datasets.push(dataset);
                }

                // Agregar el valor de la columna al dataset correspondiente
                dataset.data.push(column.value);
            });
        });

        // Crear el gráfico de barras agrupado con columnas contiguas
        var ctx = document.getElementById('bar-chart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                indexAxis: 'y', // Mostrar las columnas de forma vertical
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });

        // Función para generar un color aleatorio en formato hexadecimal
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>


