@extends('rendimiento_grupos.index')


@section('graficosrendimiento')

<script>
        window.addEventListener('DOMContentLoaded', (event) => {
            document.querySelector('#exp').value = {{ $id }};
        });
</script>

    
    <div>id es : {{$id}}</div>
    <div>Nombre : {{$experiment->name}} </div>

<!-- Incluye la biblioteca de Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<canvas id="bar-chart"></canvas>

<script>

    // Obtener los datos pasados desde el controlador
    var groupsData = {!! json_encode($groupsData) !!};
   

    var ctx = document.getElementById("bar-chart").getContext("2d");

    // Crear arrays para almacenar los nombres de los grupos y los datasets
    var groupNames = [];

    //Arreglos para almacenar los ejercicios de cada instancia
    var buenosData = [], malosData = [], omitidosData = [];

    
    // Recorrer los datos de los grupos
 groupsData.forEach(function(groupData) {
    // Agregar el nombre del grupo al array de nombres de grupos
    groupNames.push(groupData.groupName);

    // Obtener los datos de ejercicios buenos, malos y omitidos del grupo actual
    var ejerciciosBuenos = groupData.data.CantEjerBuenos || [];
    var ejerciciosMalos = groupData.data.CantEjerMalos || [];
    var ejerciciosOmitidos = groupData.data.CantEjerOmitidos || [];

     // Sumar los puntajes de ejercicios buenos, malos y omitidos
    var sumBuenos = ejerciciosBuenos.reduce((a, b) => a + b, 0) ;
    var sumMalos = ejerciciosMalos.reduce((a, b) => a + b, 0);
    var sumOmitidos = ejerciciosOmitidos.reduce((a, b) => a + b, 0);

    // Agregar los datos al dataset del grupo actual
    buenosData.push(sumBuenos );
    malosData.push(sumMalos);
    omitidosData.push(sumOmitidos);
});


var data = {
    labels: groupNames,
    datasets: [

        {
            label: "Buenas",
            backgroundColor: "green",
            data: buenosData
        },
        {
            label: "Malas",
            backgroundColor: "red",
            data: malosData
        },
        {
            label: "Omitidas",
            backgroundColor: "blue",
            data: omitidosData
        }
    ]
}

// Crear la instancia del gráfico de barras
var myBarChart = new Chart(ctx, {
    type: "bar",
    data: data,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>


<h3>Gráfico de Líneas</h3>

<canvas id="barrasApiladas"></canvas>
<!-- Agrega un elemento de selección para filtrar los grupos -->
<select id="grupoSelector">
   
</select>

<script>

    var datos = <?php echo json_encode($UsuariosPorGrupo); ?>;

    var labels = [];
    var buenasData = [];
    var malasData = [];
    var omitidasData = [];

    // Generar las opciones de grupos
    generarOpcionesGrupos();

    // Establecer "Todos" como opción seleccionada por defecto después de un retardo de 10ms
    setTimeout(function() {
        document.getElementById('grupoSelector').value = 'todos';
    }, 10);

    // Función para generar las opciones del selector de grupo
    function generarOpcionesGrupos() {
        var grupoSelector = document.getElementById('grupoSelector');
        grupoSelector.innerHTML = ''; // Limpiar las opciones existentes

        // Agregar la opción "Todos"
        var optionTodos = document.createElement('option');
        optionTodos.value = 'todos';
        optionTodos.textContent = 'Todos';
        grupoSelector.appendChild(optionTodos);

        // Agregar las opciones de cada grupo
        Object.keys(datos).forEach(function(grupo) {
            var optionGrupo = document.createElement('option');
            optionGrupo.value = grupo;
            optionGrupo.textContent = grupo;
            grupoSelector.appendChild(optionGrupo);
        });
    }

    // Función para actualizar los datos del gráfico
    function actualizarGrafico(grupo) {
        labels = [];
        buenasData = [];
        malasData = [];
        omitidasData = [];

        // Recorrer el arreglo de datos y extraer la información del grupo seleccionado
        if (grupo === 'todos') {
            Object.keys(datos).forEach(function(grupo) {
                Object.keys(datos[grupo]).forEach(function(usuario) {
                    labels.push(usuario);
                    buenasData.push(datos[grupo][usuario].Buenas);
                    malasData.push(datos[grupo][usuario].Malas);
                    omitidasData.push(datos[grupo][usuario].Omitidas);
                });
            });
        } else {
            Object.keys(datos[grupo]).forEach(function(usuario) {
                labels.push(usuario);
                buenasData.push(datos[grupo][usuario].Buenas);
                malasData.push(datos[grupo][usuario].Malas);
                omitidasData.push(datos[grupo][usuario].Omitidas);
            });
        }

        // Actualizar el gráfico con los nuevos datos
        myChart.data.labels = labels;
        myChart.data.datasets[0].data = buenasData;
        myChart.data.datasets[1].data = malasData;
        myChart.data.datasets[2].data = omitidasData;
        myChart.update();
    }

    // Configuración y generación del gráfico inicial
    var ctz = document.getElementById('barrasApiladas').getContext('2d');
var myChart = new Chart(ctz, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Buenas',
                data: buenasData,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Malas',
                data: malasData,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Omitidas',
                data: omitidasData,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        scales: {
            x: {
                stacked: true // Apilar barras verticalmente
            },
            y: {
                beginAtZero: true
            }
        }
    }
});

// Establecer "Todos" como opción seleccionada por defecto después de un retardo de 10ms
setTimeout(function() {
    document.getElementById('grupoSelector').value = 'todos';
    actualizarGrafico('todos'); // Actualizar los datos del gráfico con 'todos'
}, 10);
    // Generar las opciones de grupos y asignar el evento change al selector
    generarOpcionesGrupos();
    var grupoSelector = document.getElementById('grupoSelector');
    grupoSelector.addEventListener('change', function() {
        var grupoSeleccionado = grupoSelector.value;
        actualizarGrafico(grupoSeleccionado);
    });
</script>


@endsection