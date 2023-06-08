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
    public function index()
    {
        //$experiment = Experiment::find($experiment_id);
        $experiment = Experiment::find(3);

        $sheets = [];

        $obj = new ConsolidatedPerUserSheet($experiment);

        $aux = $obj->query();

        $UNO = $aux->get();

        $tipos_instancias = $UNO->pluck('tipo')->unique()->toArray();

      
        $Grupos = [];
        foreach ($tipos_instancias as $tipo) { // los nombres de las instancias seran la clave del array $Grupos
            $Grupos[$tipo] = [];
        }

        foreach ($UNO as $item) {

           

            //$usuarioId = $item->usuario_id;
            $nombre = $item->nombre;
            //$tipo = $item->tipo;
            //$gender = $item->gender;
            $porcBuenos = $item->qdistinctexer;
            $ejerBuenos = $item->cant_ejercicios_buenos;
            $ejerMalos = $item->cant_ejercicios_malos;
            $ejerOmitidos = $item->cant_ejercicios_omitidos;

        
            echo "Nombre: " . $nombre . "<br>";

            echo "Ejercicios distintos: " . $porcBuenos . "<br>";
            echo "Ejercicios buenos: " . $ejerBuenos . "<br>";


            $Grupos[$item->tipo]['CantEjerBuenos']  []   = $ejerBuenos ;
            $Grupos[$item->tipo]['CantEjerMalos']   []   = $ejerMalos ;
            $Grupos[$item->tipo]['CantEjerOmitidos'][]   = $ejerOmitidos ;



        }

        var_dump($Grupos);
        exit();
        //++++++++++++ Prepara datos para el grafico +++++++++++

        $groupNames = ['Numeribirds', 'AquaMath'];

        // Obtener los datos para cada grupo
        $groupsData = [];
        foreach ($groupNames as $groupName) {
            $groupData = [
                'groupName' => $groupName,
                'data' => [1,2,3,4 ]// Obtener los datos para el grupo actual
            ];
            $groupsData[] = $groupData;
        }

     
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        return view('rendimiento_grupos.index')
        ->with(compact('groupsData'))
        ->with('sheets', $sheets);
        
    }

}
