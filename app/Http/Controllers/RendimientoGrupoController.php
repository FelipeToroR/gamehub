<?php

namespace App\Http\Controllers;
use App\Models\Experiment;
use App\Models\GameInstance;
use App\Models\GameExercise;
use DB;
use App\Exports\Sheets\ConsolidatedPerUserSheet;
use App\Exports\Sheets\EvolutionPerExerciseSheet;
use App\Exports\ConsolidatedExperimentExport;





use Illuminate\Http\Request;

class RendimientoGrupoController extends Controller
{
    private $experimentos;

    public function __construct()
    {
        $this->experimentos = Experiment::all();
    }
    
    public function index()
    {

        return view('rendimiento_grupos.index', $this->getExperimentosTodos());
        
    }

    public function mostrarGraficosRendimiento(Request $request)
    {
        $experimento_id = intval($request->input('exp'));
        
        $experiment = Experiment::find($experimento_id);


        $objConsolidated = new ConsolidatedPerUserSheet($experiment);
        $datosCons = $objConsolidated->query()->get();

        $tipos_instancias = [];
        $tipos_instancias = $datosCons->pluck('tipo')->unique()->toArray();

      
        $Grupos = [];
        foreach ($tipos_instancias as $tipo) { // los nombres de las instancias seran la clave del array $Grupos
            $Grupos[$tipo] = [];
        }

        foreach ($datosCons as $item) {

            $Grupos[$item->tipo]['CantEjerBuenos']  []  = $item->cant_ejercicios_buenos;
            $Grupos[$item->tipo]['CantEjerMalos']   []  = $item->cant_ejercicios_malos;
            $Grupos[$item->tipo]['CantEjerOmitidos'][]  = $item->cant_ejercicios_omitidos;

        }

      
        //++++++++++++ Prepara datos para el grafico (agrupado vertical) +++++++++++
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $groupNames = array_keys($Grupos);

        // Obtener los datos para cada grupo
        $groupsData = [];
        foreach ($groupNames as $groupName) {
            $groupData = [
                'groupName' => $groupName,
                'data' => [
                    'CantEjerBuenos'   => $Grupos[$groupName]['CantEjerBuenos'] ,
                    'CantEjerMalos'    => $Grupos[$groupName]['CantEjerMalos']  ,
                    'CantEjerOmitidos' => $Grupos[$groupName]['CantEjerOmitidos']
                ]
                
            ];
            $groupsData[] = $groupData;
        }

      

        // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // + Prepara datos para el grafico porcentaje buenas (lineas) +
        // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $objEvolution = new EvolutionPerExerciseSheet($experiment);
        $datosEvo = $objEvolution->query()->get();
        $instanciasEvo = $datosEvo->pluck('tipo')->unique()->toArray();

        $total_ejercicios = $datosEvo->pluck('ejercicio')->unique()->flip()->toArray();
        $buenas_por_ejercicio = $datosEvo->pluck('ejercicio')->unique()->flip()->toArray();

        $users = $datosEvo->pluck('nombre')->unique()->flip()->toArray();
       
        $UsuariosPorGrupo = $datosEvo->groupBy('tipo')->map(function ($grupo) {
            return $grupo->pluck('nombre')->unique()->flip()->toArray();
        })->toArray();
        
    
        foreach ($UsuariosPorGrupo as $instancia => $usuarios) {
            
            foreach ($usuarios as $NombreUsuario => $valor) {
        
                $UsuariosPorGrupo[$instancia][$NombreUsuario] = [];
                $UsuariosPorGrupo[$instancia][$NombreUsuario]['Buenas']   = 0;
                $UsuariosPorGrupo[$instancia][$NombreUsuario]['Malas']    = 0;
                $UsuariosPorGrupo[$instancia][$NombreUsuario]['Omitidas'] = 0;
            }

        }


       /* $Total  = [];
        $Buenas = [];
        foreach ($instanciasEvo as $instancia) {
            $Total[$instancia]  = [];
            $Buenas[$instancia] = [];
        
            foreach ($total_ejercicios as $key => $valor) {
                $total_ejercicios[$key] = 0;
                $buenas_por_ejercicio[$key] = 0;
            }
        
            $Total[$instancia] = $total_ejercicios;
            $Buenas[$instancia] = $buenas_por_ejercicio;
        
            // ...
        }
      */

        foreach ($datosEvo as $item) {

            $frecuencia = explode('|', $item->secuencia);
            $frecuencia_count = count($frecuencia);

            foreach ($frecuencia as $f) {
                if ($f == 'B')
                    $UsuariosPorGrupo[$item->tipo][$item->nombre]['Buenas']   +=  1;
                else if ($f == 'M') 
                    $UsuariosPorGrupo[$item->tipo][$item->nombre]['Malas']   +=  1;
                else 
                    $UsuariosPorGrupo[$item->tipo][$item->nombre]['Omitidas']   +=  1;
            }
        }

        return view('rendimiento_grupos.graficos_rendimiento')
        ->with('groupsData' , $groupsData)
        ->with('UsuariosPorGrupo', $UsuariosPorGrupo)
        ->with($this->getExperimentosTodos())
        ->with( ['id' => $experimento_id])
        ->with('experiment' , $experiment);
        
    }

    private function getExperimentosTodos()
    {
        return [
            'experimentos' => $this->experimentos,
            
        ];
    }
}
