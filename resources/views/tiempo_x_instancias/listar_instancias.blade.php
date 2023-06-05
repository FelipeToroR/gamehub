
@extends('tiempo_x_instancias.index')


@section('graficos')

    <link rel="stylesheet" href="{{ asset('assets/css/listar-instancias.css') }}">

    <!-- Para dejar marcado el experimento -->
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            document.querySelector('#experimentos').value = {{ $id }};
        });
    </script>

    
    <p>ID: {{ $id }}</p>
    <p>nombre experimento : {{  $data['experiment']->name }}</p>
    <p>{{ $instances_list[0]->game->description }}</p>
   

    @foreach ($instances_list as $instance)

        <div class=" card col-md-{{ 12 / count($instances_list) }}">
            <div class="card bg-{{ $loop->iteration % 2 == 0 ? 'primary' : 'success' }} text-white mb-4">
                <div class="card-body">
                        <h5 class="card-title">{{ $instance->name }}</h5>
                        <a href="{{ route('tiempo_x_instancias.grafico_instancia', ['id' => $instance['id']]) }}" class="btn btn-light font-weight-bold">VER</a>
                </div>
            </div>
        </div>
        

    @endforeach

    <div class="d-flex justify-content-center mt-4">
      <button class="btn btn-primary btn-lg" style="width: 50%;">
        <a href="{{ route('tiempo_x_instancias.comparar_instancias', ['id' => $id]) }}" class="btn btn-primary">Comparar instancias</a>
        <i class="fa-sharp fa-regular fa-scale-unbalanced-flip"></i>
      </button>
    </div>


@endsection



