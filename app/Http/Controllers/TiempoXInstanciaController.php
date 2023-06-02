<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Experiment;
use App\Models\GameInstance;
use App\Models\GameExercise;
use App\User;



class TiempoXInstanciaController extends Controller
{
    private $experimentos;

    public function __construct()
    {
        $this->experimentos = Experiment::all();
    }
    
    public function index()
    {

        return view('tiempo_x_instancias.index', $this->getExperimentosTodos());
        
    }


    public function listarInstanciasAsociadas(Request $request)
    {
        $experimento_id = intval($request->input('experimentos'));


        $data = [];
        $data['experiment'] = Experiment::find($experimento_id);

       /* $users = User::select(DB::raw("user_id, users.name, users.first_surname, users.second_surname, users.course, users.course_letter, users.college"))
        ->join('user_experiments', 'user_experiments.user_id', '=', 'users.id', 'left')
        ->where('user_experiments.experiment_id', '=', $experimento_id)
        ->get();
        */

        $game_instances = Experiment::find($experimento_id)->gameInstances;

      

        $users = collect();

        // Un experimento puede tener multiples instancias (existen grupos de personas) 
        foreach ($game_instances as $instance) {
        $consulta_por_instancia = User::join('game_exercises', 'users.id', '=', 'game_exercises.user_id')
                ->where('game_exercises.game_instance_id', $instance->id)
                ->groupBy('users.id')
                ->get();

        $users = $users->merge($consulta_por_instancia);

        }
        // Recupera fecha mas lejana y mas próxima de los que hay registro
      /*  $res = GameExercise::join('game_instances', 'game_exercises.game_instance_id', '=', 'game_instances.id', 'left')
            ->where('game_instances.experiment_id', '=', $experimento_id)
            ->select(DB::raw('MIN(DISTINCT(DATE(time_start))) as start, MAX(DISTINCT(DATE(time_end))) as end'))
            ->get();

        $data['start_date'] = \Carbon\Carbon::parse($res[0]->start);
        $data['end_date'] = \Carbon\Carbon::parse($res[0]->end);

        $daysSpanish = [
            0 => 'lunes',
            1 => 'martes',
            2 => 'miércoles',
            3 => 'jueves',
            4 => 'viernes',
            5 => 'sábado',
            6 => 'domingo',
        ];

        $data['daysSpanish'] = $daysSpanish;

        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $playStudentPerDay = [];

        // Itera por las fechas desde la última hasta la mas reciente
        while (!$end_date->eq($start_date)) {
            $studentsPerDay = GameExercise::where(DB::raw('DATE(game_exercises.time_start)'), '=', $end_date->toDateString())
                ->where(function ($query) {
                    $query->where('event', '=', '1')
                        ->orWhere('event', '=', '3');
                })
                ->where('game_instances.experiment_id', '=', $experimento_id)
                ->select(DB::raw("game_exercises.event, game_exercises.time_start, user_id, users.name, users.first_surname, users.second_surname, users.course, users.course_letter, users.college"))
                ->join('users', 'game_exercises.user_id', '=', 'users.id', 'left')
                ->join('game_instances', 'game_instances.id', '=', 'game_exercises.game_instance_id', 'left')
                ->orderBy('user_id', 'ASC')
                ->orderBy('time_start', 'ASC')
                //->groupBy('user_id', DB::raw('DATE(game_exercises.time_start)'))
                ->get();

            // Agrupa ejercicios por usuario
            $studentsProcessed = [];
            if (count($studentsPerDay) > 0) {
                $data_item = [];

                // Inicializa último estudiante
                $lastStudent = $studentsPerDay[0];
                $data_item[$lastStudent->user_id] = [];
                $data_item[$lastStudent->user_id]['user'] = $lastStudent;
                $data_item[$lastStudent->user_id]['data'] = [];
                $data_item[$lastStudent->user_id]['time_total'] = \Carbon\Carbon::parse($lastStudent->time_start);

                // Inicializa último evento
                $lastEvent = $studentsPerDay[0];

                foreach ($studentsPerDay as $studentItem) {

                    // Si cambia de usuario, entonces reemplaza último usuario
                    if ($studentItem->user_id != $lastStudent->user_id) {
                        $lastStudent = $studentItem;
                        $data_item[$studentItem->user_id] = [];
                        $data_item[$studentItem->user_id]['user'] = $studentItem;
                        $data_item[$studentItem->user_id]['data'] = [];
                        $data_item[$studentItem->user_id]['time_total'] = \Carbon\Carbon::parse($studentItem->time_start);
                    }

                    // Agrega item de usuario
                    $temp_item = array(
                        'event' => $studentItem->event,
                        'time_record' => \Carbon\Carbon::parse($studentItem->time_start)
                    );

                    // Si el anterior es 1 (inicio), y actual es 3 (término)
                    if ($lastEvent->event == 1 && $studentItem->event == 3) {
                        $temp_item['diff'] = \Carbon\Carbon::parse($studentItem->time_start)->diffForHumans($lastEvent->time_start, true);
                    }

                    $data_item[$studentItem->user_id]['data'][] = $temp_item;

                    $lastEvent = $studentItem;  // Almacena último evento para próxima iteración
                }
            }
*/

           /* $item = array(
                'date' => $end_date->copy(),
                'data' => $data_item
            );
            $playStudentPerDay[] = $item;

            $end_date->addDays(-1);
        }
        $data['data'] = $playStudentPerDay;
        */

/* ###########################################################################
##############################################################################
*/

        //$experimento_id = intval($request->input('experimentos'));

       // $instances = GameInstance::where('experiment_id', $experimento)->get();
    
     
        return view('tiempo_x_instancias.listar_instancias')
                ->with( ['id' => $experimento_id])
                ->with($this->getExperimentosTodos())
                ->with('instances_list', $game_instances)
                ->with('data', $data)
                ->with('users', $users);
                

    }

    public function showgraphic($id)
{
    // Obtener la instancia correspondiente al ID y devolver a sus participantes
   
        $users  = User::join('game_exercises', 'users.id', '=', 'game_exercises.user_id')
            ->where('game_exercises.game_instance_id', $id)
            ->groupBy('users.id')
            ->get();

    

    // Pasar los datos del juego a la vista
    return view('tiempo_x_instancias.grafico_instancia', ['users' => $users]);
}



    private function getExperimentosTodos()
    {
        return [
            'experimentos' => $this->experimentos,
            
        ];
    }

    
}
