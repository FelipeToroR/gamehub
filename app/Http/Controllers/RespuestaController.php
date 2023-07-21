<?php

namespace App\Http\Controllers;

use App\Models\Experiment;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Exports\Sheets\TestPerUserSheet;
use App\User;


class RespuestaController extends Controller
{
    private $experimentos;

    public function __construct()
    {
        $this->experimentos = Experiment::all();
    }

    public function index()
    {

        return view('respuestas.index', $this->getExperimentosTodos());
        
    }

    public function listarEncuestas(Request $request)
    {
        $experimento_id = intval($request->input('expe'));
        $game_instances = Experiment::find($experimento_id)->gameInstances;

        $surveys = Survey::where('experiment_id', $experimento_id)->get();

       
        // Un experimento puede tener multiples instancias (existen grupos de personas) 
        $respuestas_por_grupo = [];
        foreach ($game_instances as $instance) {
            $consulta_por_instancia = User::join('game_exercises', 'users.id', '=', 'game_exercises.user_id')
            ->where('game_exercises.game_instance_id', $instance->id)
            ->groupBy('users.id')
            ->get();

            $users = collect();
            $users = $users->merge($consulta_por_instancia);

            $respuestas_por_grupo[$instance->name] = [];

            foreach($users as $user)
            { $respuestas_por_grupo[$instance->name][$user->name] = []; }

        }


        $sheets = [];
        foreach ($surveys as $survey) {
            $sheets[] = new TestPerUserSheet($survey);
        }

        $respuestas = [];
        foreach ($sheets as $Test) {
            $x = $Test->query()->get();

            foreach ($game_instances as $instance) {

                foreach ($x as $row) {
                    $instanceName = $instance->name;
                    $userName = $row->user_name;
                    $label = $row->label;
                    $response = $row->response;

            
                    if(!strpos($label, '_preg_') && isset($respuestas_por_grupo[$instanceName][$userName]) ) 
                    {  $respuestas_por_grupo[$instanceName][$userName][$label] = $response; }
                }
                
            }
            
        }

        $groupPercentages = [];
        $numUsuarios = 0;

        foreach ($respuestas_por_grupo as $grupoNombre => $usuarios) {
            $groupPercentages[$grupoNombre] = [];
            $numUsuarios = count($usuarios);
               foreach ($usuarios as $user => $respuestas) {
                   

                    foreach($respuestas as $label => $response){
                     
                        
                        if(isset($groupPercentages[$grupoNombre][$label])) {
                            $groupPercentages[$grupoNombre][$label] += intval($response);

                        }
                        else {
                            $groupPercentages[$grupoNombre][$label] = intval($response) ;
                        }

                    }
                    
                
               }
               // Se calculan los promedios de cada label (pre_imi_a, pre_imi_b, etc)
               $groupPercentages[$grupoNombre] = array_map(function($value) use ($numUsuarios) {
                if ($numUsuarios != 0) {
                    return $value / $numUsuarios;
                } else {
                    return 0; // valor predeterminado en caso de que no haya usuarios
                }
            }, $groupPercentages[$grupoNombre]);
        }
      
       


        return view('respuestas.listar_encuestas')
               ->with( ['id' => $experimento_id])
               ->with('groupPercentages', $groupPercentages)
               ->with($this->getExperimentosTodos());
    }

    private function getExperimentosTodos()
    {
        return [
            'experimentos' => $this->experimentos,
            
        ];
    }


}
