<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Experiment;
use App\Models\GameInstance;
use App\Models\GameExercise;
use App\User;
use ConsoleTVs\Charts\Facades\Charts;
use Carbon\Carbon;



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

        $dias_jugados = [];
        $tiempos = [];
        $tiempoTotal = 0; 
        
        foreach ($users as $user) {

            $tiempoTotalAlumno = DB::table('game_exercises')
            ->select(DB::raw('SUM(TIMESTAMPDIFF(SECOND, time_start, time_end)) as tiempo_total'))
            ->where('game_instance_id', $id)
            ->where('event', 2) // jugando
            ->where('user_id', $user->user_id)
            ->value('tiempo_total');

            $user['tiempo_total'] = $tiempoTotalAlumno/60;

            $tiempoTotal += $tiempoTotalAlumno/60;

            $tiempos[] = $tiempoTotalAlumno/60;

            // Dias en que ha jugado el alumno
            $fechasUnicas = GameExercise::distinct()
            ->select(DB::raw('DATE(time_start) as fecha'))
            ->where('user_id', $user->user_id)
            ->where('game_instance_id', $id)
            ->where('event', 2) // jugando
            ->pluck('fecha');


            $user['lista_fechas'] = $fechasUnicas;
            $lista_tiempo = [];

            if (count($fechasUnicas) > 0) {

                foreach ($fechasUnicas as $fecha) 
                { 
                    
                    // La clave NO existe, agrego la fecha
                    if (!array_key_exists($fecha, $dias_jugados))  
                    {   $dias_jugados[$fecha] = 0; }

                $tiempoTotalAlumno_por_dia = DB::table('game_exercises')
                    ->select(DB::raw('SUM(TIMESTAMPDIFF(SECOND, time_start, time_end)) as tiempo_total'))
                    ->where('game_instance_id', $id)
                    ->where('event', 2) // jugando
                    ->where('user_id', $user->user_id)
                    ->whereRaw("DATE(time_start) = ?", [$fecha])
                    ->value('tiempo_total');

                  
                    $dias_jugados[$fecha] += $tiempoTotalAlumno_por_dia;

                $lista_tiempo[] = $tiempoTotalAlumno_por_dia;
                }   

            } else{
                $tiempoTotalAlumno_por_dia = 0;
            }

            $user['tiempo_por_dia'] = $lista_tiempo;
            
            
        }  

        $fecha_mas_lejana  = Carbon::today()->format('Y-m-d');
        $fecha_mas_reciente = Carbon::today()->format('Y-m-d');

        
        if (count($dias_jugados) > 0) {  

        ksort($dias_jugados); // Se ordenan el arreglo por fechas (mas lejana hasta mas reciente)

        $fecha_mas_lejana =   array_key_first($dias_jugados);
        $fecha_mas_reciente = array_key_last($dias_jugados);

        $timestampInicio = strtotime($fecha_mas_lejana);
        $timestampFin = strtotime($fecha_mas_reciente);

        // Generar las fechas intermedias
        $fechasIntermedias = [];
        for ($i = $timestampInicio + 86400; $i < $timestampFin; $i += 86400) {
            $fechaIntermedia = date('Y-m-d', $i);
            $fechasIntermedias[] = $fechaIntermedia;
        }

        // Combinar todas las fechas en un solo arreglo
        $fechasCompletas = array_merge([$fecha_mas_lejana], $fechasIntermedias, [$fecha_mas_reciente]);
       
        }


        $tiempoPromedioPorUsuario = (count($users) > 0 ) ?  $tiempoTotal / count($users) : 0 ;
        

    // Pasar los datos del juego a la vista
    return view('tiempo_x_instancias.grafico_instancia', ['users' => $users])

        ->with('tiempos', $tiempos)

        ->with( compact('dias_jugados'))

        ->with( compact('fecha_mas_lejana', 'fecha_mas_reciente'))

        ->with( compact('fechasCompletas'))

        ->with(['promedio' => $tiempoPromedioPorUsuario]);
        
}


public function compararInstancias($id){
    return view('tiempo_x_instancias.comparar_instancias');

}





    private function getExperimentosTodos()
    {
        return [
            'experimentos' => $this->experimentos,
            
        ];
    }

    
}
