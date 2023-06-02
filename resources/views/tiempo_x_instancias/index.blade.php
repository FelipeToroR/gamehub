@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1 class="pull-left">Tiempo por instancia</h1>
        <h1 class="pull-right">
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

      

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">

           <form action="{{ route('tiempo_x_instancias.listar_instancias') }}" method="POST" id="FormularioInstancias">
            @csrf

            <!-- select box de todos los experimentos -->
            <select name="experimentos" id="experimentos" onchange="submitForm()">
            @foreach($experimentos as $experimento)
                @if($loop->first)
                    {{-- Código a ejecutar solo en la primera iteración --}}
                    <option value="-1" disabled selected> -- Seleccionar -- </option>
                @endif
                    <option value="{{ $experimento->id }}">{{ $experimento->name }}</option>
                
            
            @endforeach
            </select>
            <!-- Fin select box -->

            </form>

                
            </div>
            <div class="text-center">
          
             @yield('graficos')
        
            </div>
        </div>
        
    </div>

    <script>
    function submitForm() 
    {
        document.getElementById("FormularioInstancias").submit();
    }
    </script>

@endsection