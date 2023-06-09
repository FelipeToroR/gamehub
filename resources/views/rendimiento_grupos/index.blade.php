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

