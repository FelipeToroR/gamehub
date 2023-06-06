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

        $fechasCompletas = [];
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

        ->with( 'tiempoTotal', $tiempoTotal)


        ->with( compact('fecha_mas_lejana', 'fecha_mas_reciente'))

        ->with( compact('fechasCompletas'))

        ->with(['promedio' => $tiempoPromedioPorUsuario]);
        
}


public function compararInstancias($id){

    $game_instances = Experiment::find($id)->gameInstances;

    // -----  Para grafico de torta (comparacion tiempos) ----
    // -------------------------------------------------------

    $tiempo_total_cada_instancia = [];
    $grupos = [];
    $cursos = [];
    $colegios = [];
    foreach ($game_instances as $instance) {
        $tTotal = DB::table('game_exercises')
            ->select(DB::raw('SUM(TIMESTAMPDIFF(SECOND, time_start, time_end)) as tiempo_total'))
            ->where('game_instance_id', $instance->id)
            ->where('event', 2) // jugando
            ->value('tiempo_total');
        
        $tiempo_total_cada_instancia[$instance->name] =  $tTotal/60;

        $aux = DB::table('game_exercises')
        ->select(DB::raw("users.course, users.course_letter, users.college , game_exercises.game_instance_id"))
        ->join('users', 'game_exercises.user_id', '=', 'users.id', 'left')
        ->where('game_instance_id', $instance->id)
        ->groupBy('users.course', 'users.course_letter' )
        ->get();


        $res = $aux->map(function ($item) {
            return $item->course . ' ' . $item->course_letter;
        });

        foreach ($res as $curso_letra) {
            if (!empty($curso_letra) && $curso_letra !=" " && !in_array($curso_letra, $cursos) ){

                $cursos[] = $curso_letra;
            }
            
        }

        $resColegio = $aux->map(function ($item) {
            return $item->college;
        });

       

        foreach ($resColegio as $colegio) {
            if (!empty($colegio) && $colegio !=" " && !in_array($colegio, $colegios) ){

                $colegios[] = $colegio;
            }
            
        }

    }

    // -----  Para grafico de lineas (horas jugadas) ----
    // --------------------------------------------------
    $fechas_diff_grupos = [];
    foreach ($game_instances as $instance) {
    $fechas = DB::table('game_exercises')
                ->orderBy('time_start')
                ->where('game_instance_id', $instance->id)
                ->where('event', 2) // jugando
                ->get();
    $fechas_diff_grupos[$instance->id] = $fechas;
    }

    // Paso 2: Procesar los datos
    $datosPorHora = [];

    foreach ($game_instances as $instance) {

        $datosPorHora[$instance->name] = [];

        $fechas = $fechas_diff_grupos[$instance->id];

        foreach ($fechas as $fecha) {
            $inicio = strtotime($fecha->time_start);
            $fin = strtotime($fecha->time_end);
            $diferencia = $fin - $inicio;
            $hora = date('g a', $inicio);

            if (!isset($datosPorHora[$hora])) {
                $datosPorHora[$instance->name][$hora] = 0;
            }
        
            $datosPorHora[$instance->name][$hora] += $diferencia;
        }
    }

    return view('tiempo_x_instancias.comparar_instancias')
    ->with(compact('tiempo_total_cada_instancia'))
    ->with(compact('colegios'))
    ->with(compact('cursos'))
    ->with(compact('datosPorHora'))
    ->with(compact('game_instances'));

}



    private function getExperimentosTodos()
    {
        return [
            'experimentos' => $this->experimentos,
            
        ];
    }

    
}
