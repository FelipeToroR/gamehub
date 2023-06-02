<?php

namespace App\Http\Controllers;

use DB;
use App\DataTables\GameInstanceDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\Controllers\Gamification\GameInstanceGamificationController;
use App\Http\Requests\CreateGameInstanceRequest;
use App\Http\Requests\UpdateGameInstanceRequest;
use App\Models\GameInstance;
use App\Models\GameBadge;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\UserRewardTransaction;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

use App\Services\EncryptService;
use App\Models\GameExercise;
use App\Models\TestExercise;
use App\Models\Experiment;
use App\Models\Reward;
use App\Models\RewardDay;
use App\Models\RewardDayItem;


use Illuminate\Support\Str;

use App\Models\GameInstanceTimeCounter;
use App\Models\UserGameBadge;
use App\Models\GameInstanceScore;
use App\Models\GameInstanceTime;
use App\Models\GameInstanceParameter;
use App\Models\UserCurrency;
use App\Models\UserExperiment;
use App\Services\Gamification\CurrencyService;
use App\Services\Gamification\ExperienceService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class GameInstanceController extends AppBaseController
{
    /**
     * Display a listing of the GameInstance.
     *
     * @param GameInstanceDataTable $gameInstanceDataTable
     * @return Response
     */
    public function index(GameInstanceDataTable $gameInstanceDataTable, $experiment_id)
    {
        return $gameInstanceDataTable
            ->with('experiment_id', $experiment_id)
            ->render('game_instances.index', ['experiment_id' => $experiment_id]);
    }

    /**
     * Show the form for creating a new GameInstance.
     *
     * @return Response
     */
    public function create($experiment_id)
    {
        return view('game_instances.create')
            ->with('experiment_id', $experiment_id);
    }

    /**
     * Store a newly created GameInstance in storage.
     *
     * @param CreateGameInstanceRequest $request
     *
     * @return Response
     */
    public function store($experiment_id, CreateGameInstanceRequest $request)
    {
        $input = $request->all();

        /** @var GameInstance $gameInstance */
        $input['experiment_id'] = $experiment_id;
        $gameInstance = GameInstance::create($input);

        Flash::success('Game Instance saved successfully.');

        return redirect(route('experiments.game-instances.index', $experiment_id));
    }

    /**
     * Display the specified GameInstance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($experiment_id, $slug)
    {
        // Verifica si existe la instancia basado en slug
        $gameInstance = GameInstance::findBySlug($slug);

        if (empty($gameInstance)) {
            Flash::error('Game Instance not found');
            return redirect(route('experiments.game-instances.index', $experiment_id));
        }

        $params = $gameInstance;
        $json_params = array();
        foreach ($gameInstance->instance_parameters as $param) {
            $json_params[$param->gameParameter->name] = $param->name;   //Se muestra como string algunos (unificar version)
        }


        return view('game_instances.show')
            ->with('experiment_id', $experiment_id)
            ->with('gameInstance', $gameInstance)
            ->with('params', json_encode($json_params, JSON_PRETTY_PRINT));
    }

    /**
     * Show the form for editing the specified GameInstance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($experiment_id, $id)
    {
        /** @var GameInstance $gameInstance */
        $gameInstance = GameInstance::find($id);

        if (empty($gameInstance)) {
            Flash::error('Game Instance not found');
            return redirect(route('experiments.game-instances.index', $experiment_id));
        }

        // Listado de ítemes de experimento, incluye valor nulo.
        $rewardItems = Reward::pluck('name', 'id')->toArray();
        $rewardItems[null] = 'Ninguno';


        return view('game_instances.edit')
            ->with('rewardItems', $rewardItems)
            ->with('experiment_id', $experiment_id)
            ->with('gameInstance', $gameInstance);
    }

    /**
     * Update the specified GameInstance in storage.
     *
     * @param  int              $id
     * @param UpdateGameInstanceRequest $request
     *
     * @return Response
     */
    public function update($experiment_id, $id, UpdateGameInstanceRequest $request)
    {
        /** @var GameInstance $gameInstance */
        $gameInstance = GameInstance::find($id);

        if (empty($gameInstance)) {
            Flash::error('Game Instance not found');

            return redirect(route('experiments.game-instances.index', $experiment_id));
        }

        $gameInstance->fill($request->all());
        $gameInstance->save();

        Flash::success('Game Instance updated successfully.');

        return redirect(route('experiments.game-instances.index', $experiment_id));
    }

    /**
     * Remove the specified GameInstance from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($experiment_id, $id)
    {
        /** @var GameInstance $gameInstance */
        $gameInstance = GameInstance::find($id);

        if (empty($gameInstance)) {
            Flash::error('Instancia de juego no encontrada');
            return redirect(route('experiments.game-instances.index', $experiment_id));
        }

        if ($gameInstance->exercises->count()) {
            Flash::error('La instancia de juego tiene ejercicios asociados, no se puede borrar');
            return redirect(route('experiments.game-instances.index', $experiment_id));
        }

        $gameInstance->delete();

        Flash::success('La instancia de juego se ha eliminado exitosamente del experimento');

        return redirect(route('experiments.game-instances.index', $experiment_id));
    }

    public function play(Request $request)
    {

        $game_slug = $request->segment(2);
        $game_instance_id = $request->segment(3);
        $token = $request->input('t');
        $hash = $request->input('h');
        $token_decrypt = (new EncryptService())->encrypt_decrypt('decrypt', $token);
        $game_instance = GameInstance::where('slug', $game_instance_id)->first();
         // Comprueba si hay encuestas programadas por fecha
        $survey_by_date = Experiment::find($game_instance->experiment_id)->surveys
            ->where('type', '=', 2)     // Tipo de encuesta programada por fecha
            ->where('initial_date', '<=', \Carbon\Carbon::now()->toDateTimeString())
            ->where('end_date', '>=', \Carbon\Carbon::now()->toDateTimeString())
            ->first();

        // Si existe encuesta programada, la ejecuta

        if (!empty($survey_by_date)) {

            // Verifica si ya respondió la última pregunta

            $survey_by_date_response = SurveyResponse::where('user_id', Auth::user()->id)
                ->where('experiment_id', $game_instance->experiment_id)
                ->where('survey_id', $survey_by_date->id)
                ->where('label', '=', 'end')        // Busca elemento de término de encuesta programada
                ->orderBy('created_at', 'DESC')
                ->orderBy('id', 'DESC')
                ->first();


            if (empty($survey_by_date_response)) {

                // Envia a iniciar / terminar encuesta programada

                return redirect(
                    route(
                        'survey.run',
                        [
                            $game_instance->experiment_id,
                            $survey_by_date->id
                        ]
                    )
                );
            }
        }

        // Comprueba si hay encuestas programadas por avance
        
        
        $s_o_v_t_i_h_t_g_f_s_i_o_u_c = UserExperiment::where("user_id", Auth::user()->id)
            ->where('experiment_id', '=', $game_instance->experiment_id)     // Tipo de encuesta programada por fecha
            ->first();
        $surveys_by_advance = Experiment::find($game_instance->experiment_id)->surveys
            ->where('type', '=', 3)     // Tipo de encuesta programada por fecha
            ->where('responses_expected', '<=', $s_o_v_t_i_h_t_g_f_s_i_o_u_c->actual_responses);
        
        // Si existe encuesta programada, la ejecuta
        
        if (!empty($surveys_by_advance)) {
            foreach($surveys_by_advance as $survey_by_advance) {
                // Verifica si ya respondió la última pregunta

                $survey_by_advance_response = SurveyResponse::where('user_id', Auth::user()->id)
                    ->where('experiment_id', $game_instance->experiment_id)
                    ->where('survey_id', $survey_by_advance->id)
                    ->where('label', '=', 'end')        // Busca elemento de término de encuesta programada
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->first();


                if (empty($survey_by_advance_response)) {

                    // Envia a iniciar / terminar encuesta programada

                    return redirect(
                        route(
                            'survey.run',
                            [
                                $game_instance->experiment_id,
                                $survey_by_advance->id
                            ]
                        )
                    );
                }
            }
        }

        // Comprueba si hay encuestas programadas por avance y tiempo
        $surveys_by_mix = Experiment::find($game_instance->experiment_id)->surveys
            ->where('type', '=', 4)     // Tipo de encuesta programada por ambos
            ->where('responses_expected', '<=', $s_o_v_t_i_h_t_g_f_s_i_o_u_c->actual_responses);
        /* 
        $surveys_by_mix->merge(Experiment::find($game_instance->experiment_id)->surveys
        ->where('initial_date', '<=', \Carbon\Carbon::now()->toDateTimeString())
        ->where('end_date', '>=', \Carbon\Carbon::now()->toDateTimeString())); */
        // Si existe encuesta al final, comprueba si es necesario ejecutarla
        if (!empty($surveys_by_mix)) {
            foreach($surveys_by_mix as $survey_by_mix) {
                // Verifica si ya respondió la última pregunta del test
                $survey_by_mix_response = SurveyResponse::where('user_id', Auth::user()->id)
                    ->where('experiment_id', $game_instance->experiment_id)
                    ->where('survey_id', $survey_by_mix->id)
                    ->where('label', '=', 'end')        // Busca elemento de término de encuesta programada
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->first();


                if (empty($survey_by_mix_response)) {

                    // Envia a iniciar / terminar encuesta programada

                    return redirect(
                        route(
                            'survey.run',
                            [
                                $game_instance->experiment_id,
                                $survey_by_mix->id
                            ]
                        )
                    );
                }
            }
        }
        $game_extra = $game_instance->game->extra;
        $game_extra_decode = json_decode($game_extra, true);
        $game = $game_instance->game;
 
        if (isset($game_extra_decode['filename'])) {
            if ($token_decrypt == $game_instance_id) {

                return view('game_instances.play')
                    ->with('layout', ['w' => $game->width, 'h' => $game->height, 'proportion' => $game->proportion])
                    ->with('gameInstance', $game_instance)
                    ->with('experiment_id', $game_instance->experiment_id)
                    ->with('game_slug', $game_slug)
                    ->with('game_instance_slug', $game_instance_id)
                    ->with('jsname', $game_extra_decode['filename']);
            } else {
                Flash::error('Game Instance not found. ' . $token_decrypt . ' <> ' . $game_instance_id);
                return redirect(route('game-instances.index'));
            }
        } else {
            Flash::error('Game config not found. ');
            return redirect(route('game-instances.index'));
        } 

        /*
            $instance_time = new GameInstanceTime();
            $instance_time->date = date('Y-m-d');
            $instance_time->remaining_time = $default_time_per_day;
            $instance_time->game_instance_id = 1;//$game_instance->id;
            $instance_time->user_id = $user_id;
            $instance_time->save();
            
            */
    }

    // Entrega parámetros de juego
    public function initial_params(Request $request, CurrencyService $currencyService)
    {

        $data = $request->all();

        // PARCHE TEMPORAL
        /*if(Str::endsWith($data['t'], '%3D')){
            $data['t'] = Str::substr($data['t'], -3);
        }*/

        // Cargar instancia de juego        
        $game_instance_slug = (new EncryptService())->encrypt_decrypt('decrypt', urldecode($data['t']));
        $game_instance = GameInstance::findBySlug($game_instance_slug);
        //$game_instance->id;


        // Recupera identificador 
        $user = Auth::user();
        $user_id = $user->id;

        // Recupera puntaje máximo
        $instance_score = GameInstanceScore::where('user_id', $user_id)
            ->where('game_instance_id', $game_instance->id)->first();
        if ($instance_score) {
            $max_score = $instance_score->max_score;
        } else {
            $max_score = 0;
        }

        // Recupera tiempo restante
        $instance_time = GameInstanceTime::where('user_id', $user_id)
            ->where('game_instance_id',  $game_instance->id)
            ->where('date', \Carbon\Carbon::now()->toDateString())
            ->first();
        if ($instance_time) {
            // Recupera tiempo restante
            $remaining_time = $instance_time->remaining_time;
        } else {
            // Asigna tiempo por defecto
            $default_time_per_day = 90000;   // 1800 = 30 minutos
            $remaining_time = $default_time_per_day;
        }


        // Rescate de parámetros
        $parameters = GameInstanceParameter::where('game_instance_id', $game_instance->id)->get();
        $parameters_json = array();
        foreach ($parameters as $parameter_item) {
            if ($parameter_item->gameParameter->type == 'int') {
                $parameters_json[$parameter_item->variable] = (int) $parameter_item->name;
            } else if ($parameter_item->gameParameter->type == 'decimal') {
                $parameters_json[$parameter_item->variable] = (float) $parameter_item->name;
            } else  if ($parameter_item->gameParameter->type == 'boolean') {
                if (strtolower($parameter_item->name) == 'true' || $parameter_item->name == '1') {
                    $parameters_json[$parameter_item->variable] = true;
                } else {
                    $parameters_json[$parameter_item->variable] = false;
                }
            } else {
                $parameters_json[$parameter_item->variable] = $parameter_item->name;
            }
        }


        # Carga de tags de tests
        $tests = TestExercise::where('user_id', '=', $user_id)
            ->where('event', 2)
            ->select(DB::raw('DISTINCT(test) as test, (SELECT label FROM test_exercises WHERE user_id = ' . $user_id . ' ORDER BY created_at DESC, time_start DESC, id DESC LIMIT 1) as last_label'))
            ->get();

        # Carga de monedas actual
        $currencyAmount = $currencyService->getUserAmount($user_id, $game_instance->id);


        $game_instance_time_counter = GameInstanceTimeCounter::where('game_instance_id', $game_instance->id)
            ->where('date', \Carbon\Carbon::now()->toDateString())
            ->where('user_id', $user_id)
            ->orderBy('date', 'DESC')
            ->first();

        $time_counter = (!empty($game_instance_time_counter)) ? $game_instance_time_counter->time_used : 0;


        $arr = [
            'u' => [

                # Parámetros de juego
                'name' => $user->name,              # Nombre de usuario
                'fullname' => $user->name,          # Nombre completo del usuario
                'username' => $user->name,          # Nombre de usuario
                'max_score' => $max_score,          # Puntaje máximo (record) de juego

                # Parámetros de gamificación
                'currency' => $currencyAmount,      # Cantidad de monedas actual
                'badges' => [],                     # Arreglo de medallas de usuario

                # Parámetros de tiempo
                'time_used' => $time_counter,      # Tiempo usado
                'time_limit' => $game_instance->experiment->time_limit,     # Tiempo límite del día
                'time_left' => (3600 * 24),                                   # (deprecated) Tiempo restante

                # Parámetros de test
                'tests' => $tests->toArray(),       # Arreglo de tests realizados
            ],
            'p' => $parameters_json
        ];


        # Carga medallas adquiridas por el usuario
        $badgeAcquired = UserGameBadge::leftjoin('game_badges', 'user_game_badges.game_badge_id', 'game_badges.id')
            ->where('user_game_badges.user_id', $user_id)
            ->where('user_game_badges.game_id', $game_instance->game->id)
            ->select(DB::raw('game_badges.code as code'))
            ->distinct('code')
            ->get();

        $badge_list = [];
        foreach ($badgeAcquired as $badgeAcquiredItem) {
            $badgeItem = [];
            $badgeItem['name'] = $badgeAcquiredItem->code;
            $badge_list[] = $badgeItem;
        }
        $arr['u']['badges'] = $badge_list;

        # Carga de total de ejercicios
        $total_exercises_count = GameExercise::where('user_id', $user->id)
            ->where('game_instance_id', $game_instance->id)
            ->count();
        $arr['u']['total_exercises'] = $total_exercises_count;

        # FIX: Corrige retorno de arreglo cuando corresponde a diccionario
        # PHP considera arreglo vació como arreglo, no hay forma de definir diccionaro (arr. asosciativo)
        if (count($arr['p']) == 0) {
            $arr['p'] = json_decode("{}");
        }

        return response()
            ->json($arr);
    }

    // Almacena datos de juego
    public function save_data(Request $request, ExperienceService $experienceService, CurrencyService $currencyService)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $game_data = $request->input('game');
        $exercise_list = $request->input('exercises');

        # Comprueba si hay presencia de token
        if (isset($game_data['token'])) {

            $game_instance_slug = (new EncryptService())->encrypt_decrypt('decrypt', urldecode($game_data['token']));
            $game_instance = GameInstance::findBySlug($game_instance_slug);
           
            $user_experiment = UserExperiment::where('game_instance_id', $game_instance->id)
                ->where('user_id', $user->id)
                ->first();
            $expected_advance = Experiment::find($user_experiment->experiment_id)->surveys
                ->whereBetween('type', [3, 4])     // Tipo de encuesta programada por ambos
                ->where('responses_expected', '>=', $user_experiment->actual_responses)
                ->sortBy('responses_expected')
                ->first();

            // Agrega experiencia al usuario
            if (isset($game_data['experience'])) {
                $user_experience = $experienceService->addUserAmount($user->id, $game_instance->id, $game_data['experience']);
            }

            // Agrega registro de tiempo
            if (isset($game_data['time_used'])) {

                // Recupera instancia de tiempo
                $instance_time = GameInstanceTimeCounter::where('user_id', $user_id)
                    ->where('game_instance_id', $game_instance->id)
                    ->where('date', \Carbon\Carbon::now()->toDateString())
                    ->first();

                if (!empty($instance_time)) {
                    // Edita puntaje de instancia de tiempo existente
                    $instance_time->time_used = $instance_time->time_used + $game_data['time_used'];
                } else {
                    // Crea primera instancia de tiempo
                    $instance_time = new GameInstanceTimeCounter();
                    $instance_time->date = \Carbon\Carbon::now();
                    $instance_time->time_used = $game_data['time_used'];
                    $instance_time->game_instance_id = $game_instance->id;
                    $instance_time->user_id = $user_id;
                }
                $instance_time->save();
            }

            // Agregar puntaje máximo
            if (isset($game_data['max_score'])) {
                $instance_score = GameInstanceScore::where('user_id', $user_id)
                    ->where('game_instance_id', $game_instance->id)
                    ->first();

                if ($instance_score) {
                    // Edita puntaje de instancia de puntaje existente
                    // Solo si el puntaje actual es mayor al anterior
                    if ($instance_score->max_score < $game_data['max_score']) {
                        $instance_score->max_score = $game_data['max_score'];
                        $instance_score->save();
                    }
                } else {
                    // Crea primera instancia de puntaje
                    $instance_score = new GameInstanceScore();
                    $instance_score->max_score = $game_data['max_score'];
                    $instance_score->game_instance_id = $game_instance->id;
                    $instance_score->user_id = $user_id;
                    $instance_score->save();
                }
            }

            // Almacena monedas, si es test, tiene currency, tiene un evento 3
            // ** Utilizado para entregar monedas al terminar un test (in-game) **
            if (isset($game_data['add_currency'])) {
                // Realiza transaccion de monto
                $user_currency = $currencyService->addUserAmount($user->id, $game_instance->id, $game_data['add_currency']);
            }

            # Si no definió test, graba ejercicio
            if (!isset($game_data['test'])) {
				
                foreach ($exercise_list as $exercise_item) {
                    # [FIX] Corrige entrada de eventos de modo string
                    if (is_string($exercise_item)) {
                        $exercise_item = json_decode($exercise_item, true);
                    }
                    # Registra evento de ejercicio
                    $this->record_game_exercise($game_instance, $user_id, $exercise_item, $game_data);
                }
            } else {

                # Si definió test, graba en ejercicio de test
                foreach ($exercise_list as $exercise_item) {

                    # [FIX] Corrige entrada de eventos de modo string
                    if (is_string($exercise_item)) {
                        $exercise_item = json_decode($exercise_item, true);
                    }

                    # Registra evento de test
                    $this->record_test_exercise($game_instance, $user_id, $exercise_item, $game_data);
                }
            }




            $badge_list = $request->input('badges');

            if (isset($badge_list)) {

                foreach ($badge_list as $badge_item) {

                    # [FIX] Corrige entrada de eventos de modo string
                    if (is_string($badge_item)) {
                        $badge_item = json_decode($badge_item, true);
                    }

                    # Registra evento de medalla
                    $this->record_badge($game_instance->game->id, $user_id, $badge_list);
                }
            }


	
			$user_experiment = UserExperiment::where('game_instance_id', $game_instance->id)
                ->where('user_id', $user->id)
                ->first();
            $json = [
                'result' => 0
            ];
            if (!empty($expected_advance)) {
                $upped_value = $user_experiment->actual_responses >= $expected_advance->responses_expected;
            } else {
                $upped_value = false;
            }
            if (isset($game_data['time_used'])) {
                $json['game'] = [
                    'time_used' => $instance_time->time_used,
                    'timeout' => ($instance_time->time_used >= $game_instance->experiment->time_limit)
                ];
            } 
            
            $json['game']['complete'] = $upped_value;

            return response()->json($json);
        } else {
            return response()->json([
                'result' => -1,
                'message' => 'Invalid token'
            ]);
        }
    }

    /**
     * Registra un evento de juego
     */
    private function record_game_exercise($game_instance, $user_id, $exercise_item)
    {

        $gexercise = new GameExercise();
        $gexercise->game_instance_id = $game_instance->id;
        $gexercise->user_id = $user_id;

        if ($exercise_item['event'] == 1) {

            // (1): Evento de inicio de partida
            $gexercise->event = 1;
            $gexercise->round = $exercise_item['round'];
            $gexercise->time_start = $exercise_item['timeStart'];
        } else if ($exercise_item['event'] == 2) {
			$add_up_userexp = UserExperiment::where('game_instance_id', $game_instance->id)
                ->where('user_id', $user_id)
                ->first();
			$add_up_userexp->actual_responses = $add_up_userexp->actual_responses + 1;
			$add_up_userexp->save();
            // (2): Evento de ejercicio
            $gexercise->event = 2;
            $gexercise->round = $exercise_item['round'];
            $gexercise->exercise = $exercise_item['exercise'];
            $gexercise->response = $exercise_item['response'];
            $gexercise->user_response = $exercise_item['userResponse'];
        } else if ($exercise_item['event'] == 3) {

            // (3): Evento de término de partida
            $gexercise->event = 3;
            $gexercise->round = $exercise_item['round'];
        } else if ($exercise_item['event'] == 4) {

            // (4): Evento de salida inesperada del navegador
            $gexercise->event = 4;
            $gexercise->round = $exercise_item['round'];
        }

        # Si define 'score' lo almacena
        if (isset($exercise_item['score'])) {
            $gexercise->score = $exercise_item['score'];
			
        }

        # Si define 'lives' lo almacena
        if (isset($exercise_item['lives'])) {
            $gexercise->lives = $exercise_item['lives'];
        }

        # Si define 'lives' lo almacena
        if (isset($exercise_item['origin'])) {
            $gexercise->memory_origin = $exercise_item['origin'];
        }

        # Si define 'lives' lo almacena
        if (isset($exercise_item['question_type'])) {
            $gexercise->type = $exercise_item['question_type'];
        }

        # Si define 'timeStart' con formato correcto lo almacena
        if (isset($exercise_item['timeStart']) && strtotime(str_replace('/', '-', $exercise_item['timeStart'])) != false) {
            $gexercise->time_start = Carbon::createFromFormat('d/m/Y H:i:s', $exercise_item['timeStart'])->toDateTimeString();
        }

        # Si define 'timeEnd' con formato correcto, sino almacena 'timeStart'
        if (isset($exercise_item['timeEnd']) && strtotime(str_replace('/', '-', $exercise_item['timeEnd'])) != false) {
            $gexercise->time_end = Carbon::createFromFormat('d/m/Y H:i:s', $exercise_item['timeEnd'])->toDateTimeString();
        } else {
            $gexercise->time_end = Carbon::createFromFormat('d/m/Y H:i:s', $exercise_item['timeStart'])->toDateTimeString();
        }

        # Si define 'extras' con formato correcto lo almacena
        if (isset($exercise_item['extras'])) {
            $gexercise->extra = json_encode($exercise_item['extras']);
        }

        $gexercise->save();
		if ($exercise_item['event'] == 2) {
			return ($add_up_userexp->actual_responses);
		} else {
			return -1;
		}
    }

    /**
     * Registra un evento de juego
     */
    private function record_test_exercise($game_instance, $user_id, $exercise_item, $game_data)
    {

        // Solo almacena los registros de test de ejercicio
        if ($exercise_item['event'] == 2) {
            $gexercise = new TestExercise();
            $gexercise->game_instance_id = $game_instance->id;
            $gexercise->user_id = $user_id;
            $gexercise->test = $game_data['test'];
            $gexercise->event = 2;
            $gexercise->exercise = $exercise_item['exercise'];
            $gexercise->response = $exercise_item['response'];
            $gexercise->user_response = $exercise_item['userResponse'];
            $gexercise->label = $exercise_item['label'];

            # Si define 'timeStart' con formato correcto lo almacena
            if (isset($exercise_item['timeStart']) && strtotime(str_replace('/', '-', $exercise_item['timeStart'])) != false) {
                $gexercise->time_start = Carbon::createFromFormat('d/m/Y H:i:s', $exercise_item['timeStart'])->toDateTimeString();
            }

            # Si define 'timeEnd' con formato correcto, sino almacena 'timeStart'
            if (isset($exercise_item['timeEnd']) && strtotime(str_replace('/', '-', $exercise_item['timeEnd'])) != false) {
                $gexercise->time_end = Carbon::createFromFormat('d/m/Y H:i:s', $exercise_item['timeEnd'])->toDateTimeString();
            } else {
                $gexercise->time_end = Carbon::createFromFormat('d/m/Y H:i:s', $exercise_item['timeStart'])->toDateTimeString();
            }

            # Si define 'extras' con formato correcto lo almacena
            if (isset($exercise_item['extras'])) {
                $gexercise->extra = json_encode($exercise_item['extras']);
            }

            $gexercise->save();
        }
    }

    /**
     * Registra un evento de medalla
     */
    private function record_badge($game_id, $user_id, $badge_list)
    {
        foreach ($badge_list as $badge_item) {
            $ugamebadge = new UserGameBadge;
            $badge = GameBadge::where('code', $badge_item['name'])->where('game_id', $game_id)->first();
            if (!empty($badge)) {
                $ugamebadge->game_badge_id = $badge->id;
                $ugamebadge->game_id = $game_id;
                $ugamebadge->user_id = $user_id;
                //$ugamebadge->created_at = $badge_item['time'];
                $ugamebadge->save();
            }
        }
    }


    public function add_day_reward($game_instance_id)
    {
        // POR AHORA, NO CUBRE DIAS INTERMEDIOS ...

        $user = Auth::user();

        $urtlist = UserRewardTransaction::where('game_instance_id', $game_instance_id)
            ->where('user_id', $user)
            ->get();

        $urt = new UserRewardTransaction;
        $urt->game_instance_id = 1;
        $urt->user_id = 1;
        $urt->day_counter = 1;
    }


    /**
     * LÓGICA DE HUBNEDAS
     */

    private function get_currency()
    {
        //UserCurrency::get()
        return;
    }





    // Selecciona la instancia de juego para el usuario.
    public function goto_game_instance($experiment_id)
    {

        // Verifica si existe una encuesta para el experimento
        //
        $user = Auth::user();



        if ($user->developer_mode == 1) {

            // Modo de desarrollador

            # Lista de todas las encuestas del experimento
            $surveys = Experiment::find($experiment_id)->surveys;

            # Lista todas las instancias de juego, pertenecientes al experimento
            $game_instances = Experiment::find($experiment_id)->gameInstances;

            # Retorna vista con redirección
            return view('game_instances.switch-developer-mode')
                ->with('instances_list', $game_instances)
                ->with('surveys_list', $surveys)
                ->with('experiment_id', $experiment_id);
        } else {

            // Recupera la primera encuesta del experimento, de tipo 'ENCUESTA INICIAL' = 1
            $survey = Experiment::find($experiment_id)->surveys->where('type', '=', 1)->first();

            if (!empty($survey)) {

                // Verifica si ya respondió la última pregunta

                $survey_response = SurveyResponse::where('user_id', Auth::user()->id)
                    ->where('experiment_id', $experiment_id)
                    ->where('survey_id', $survey->id)
                    ->where('label', '=', 'end')        // Busca elemento de término
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->first();


                if (empty($survey_response)) {

                    // Envia a iniciar / terminar encuesta

                    return redirect(
                        route(
                            'survey.run',
                            [
                                $experiment_id,
                                $survey->id
                            ]
                        )
                    );
                }
            }


            // Comprueba si hay encuestas programadas por fecha
            $survey_by_date = Experiment::find($experiment_id)->surveys
                ->where('type', '=', 2)     // Tipo de encuesta programada por fecha
                ->where('initial_date', '<=', \Carbon\Carbon::now()->toDateTimeString())
                ->where('end_date', '>=', \Carbon\Carbon::now()->toDateTimeString())
                ->first();

            // Si existe encuesta programada, la ejecuta

            if (!empty($survey_by_date)) {

                // Verifica si ya respondió la última pregunta

                $survey_by_date_response = SurveyResponse::where('user_id', Auth::user()->id)
                    ->where('experiment_id', $experiment_id)
                    ->where('survey_id', $survey_by_date->id)
                    ->where('label', '=', 'end')        // Busca elemento de término de encuesta programada
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->first();


                if (empty($survey_by_date_response)) {

                    // Envia a iniciar / terminar encuesta programada

                    return redirect(
                        route(
                            'survey.run',
                            [
                                $experiment_id,
                                $survey_by_date->id
                            ]
                        )
                    );
                }
            }

			// Comprueba si hay encuestas programadas por avance
			$s_o_v_t_i_h_t_g_f_s_i_o_u_c = UserExperiment::where("user_id", $user->id)
                ->where('experiment_id', '=', $experiment_id)     // Tipo de encuesta programada por fecha
                ->first();
            $surveys_by_advance = Experiment::find($experiment_id)->surveys
                ->where('type', '=', 3)     // Tipo de encuesta programada por fecha
                ->where('responses_expected', '<=', $s_o_v_t_i_h_t_g_f_s_i_o_u_c->actual_responses);
            // Si existe encuesta programada, la ejecuta

            if (!empty($surveys_by_advance)) {
                foreach($surveys_by_advance as $survey_by_advance) {
                    // Verifica si ya respondió la última pregunta
                    $survey_by_advance_response = SurveyResponse::where('user_id', Auth::user()->id)
                        ->where('experiment_id', $experiment_id)
                        ->where('survey_id', $survey_by_advance->id)
                        ->where('label', '=', 'end')        // Busca elemento de término de encuesta programada
                        ->orderBy('created_at', 'DESC')
                        ->orderBy('id', 'DESC')
                        ->first();


                    if (empty($survey_by_advance_response)) {

                        // Envia a iniciar / terminar encuesta programada

                        return redirect(
                            route(
                                'survey.run',
                                [
                                    $experiment_id,
                                    $survey_by_advance->id
                                ]
                            )
                        );
                    }
                }
            }

			// Comprueba si hay encuestas programadas por avance y tiempo
            $surveys_by_mix = Experiment::find($experiment_id)->surveys
                ->where('type', '=', 4)     // Tipo de encuesta programada por ambos
                ->where('responses_expected', '<=', $s_o_v_t_i_h_t_g_f_s_i_o_u_c->actual_responses);
            $surveys_by_mix->merge(Experiment::find($experiment_id)->surveys
                ->where('type', '=', 4)     // Tipo de encuesta programada por ambos
                ->where('initial_date', '<=', \Carbon\Carbon::now()->toDateTimeString())
                ->where('end_date', '>=', \Carbon\Carbon::now()->toDateTimeString()));
        
            // Si existe encuesta al final, comprueba si es necesario ejecutarla
            if (!empty($surveys_by_mix)) {
                foreach ($surveys_by_mix as $survey_by_mix) {
                    // Verifica si ya respondió la última pregunta del test
                    $survey_by_mix_response = SurveyResponse::where('user_id', Auth::user()->id)
                        ->where('experiment_id', $experiment_id)
                        ->where('survey_id', $survey_by_mix->id)
                        ->where('label', '=', 'end')        // Busca elemento de término de encuesta programada
                        ->orderBy('created_at', 'DESC')
                        ->orderBy('id', 'DESC')
                        ->first();


                    if (empty($survey_by_mix_response)) {

                        // Envia a iniciar / terminar encuesta programada

                        return redirect(
                            route(
                                'survey.run',
                                [
                                    $experiment_id,
                                    $survey_by_mix->id
                                ]
                            )
                        );
                    }
                }
            }

            // Recupera instancia de juego segun usuario y experimento
            $user_experiment_instance = UserExperiment::where('experiment_id', $experiment_id)
                ->where('user_id', $user->id)
                ->first();

            // Verifica si usuario en experimento tiene instancia de juego asociada

            if ($user_experiment_instance->game_instance_id == null) {

                // Selecciona las instancias del experimento con menos usuarios asignados

                $assign_game_instance = GameInstance::leftjoin('user_experiments', 'game_instances.id', '=', 'user_experiments.game_instance_id')
                    ->select(DB::raw('game_instances.id, COUNT(user_experiments.id) as contador'))
                    ->where('game_instances.experiment_id', $experiment_id)
                    ->groupBy('game_instances.id')
                    ->orderBy('contador', 'ASC')
                    ->first();

                // Si la instancia no tiene juegos, lo informa.

                if (empty($assign_game_instance)) {
                    echo 'Instancia sin juegos';
                    return;
                }

                // Asigna instancia de juego a experimento.

                $user_experiment_instance->game_instance_id = $assign_game_instance->id;
                $user_experiment_instance->save();
            }

            // Selecciona juego de su instancia ya asignada, y redirige a juego.
            $game_instance = GameInstance::where('id', $user_experiment_instance->game_instance_id)->first();

            // Finalmente, redirije a juego
            return redirect(
                route(
                    'game-instances.play',
                    [
                        $game_instance->game->slug,
                        $game_instance->slug,
                        't' => (new EncryptService())->encrypt_decrypt('encrypt', $game_instance->slug)
                    ]
                )
            );
        }
    }

    public function score_list($experiment_id)
    {

        $score = GameInstanceScore::leftjoin('user_experiments', function ($join) {
            $join->on('game_instance_scores.game_instance_id', '=', 'user_experiments.game_instance_id')
                ->on('game_instance_scores.user_id', '=', 'user_experiments.user_id');
        }) //, 'game_instance_scores.game_instance_id', '=', 'user_experiments.game_instance_id')
            ->leftjoin('users', 'game_instance_scores.user_id', '=', 'users.id')
            ->select(['max_score', 'name', 'first_surname', 'second_surname', 'course', 'course_letter'])
            ->where('user_experiments.experiment_id', $experiment_id)
            ->orderBy('max_score', 'desc')
            ->get();

        return response()->json(['lb' => $score]);
    }

    public function test_survey($experiment_id, $survey_id)
    {
        $user = Auth::user();

        $experiment = Experiment::find($experiment_id);

        if (empty($experiment)) {
            Flash::error('Experimento no encontrado');
            return redirect('/');
        }

        // Recupera primera encuesta
        $survey = Survey::where('id', $survey_id)->where('experiment_id', $experiment_id)->first();

        // Recupera último resultado de encuesta
        $last_survey = SurveyResponse::where('survey_id', '=', $survey_id)
            ->where('experiment_id', '=', $experiment_id)
            ->where('user_id', '=', $user->id)
            ->orderBy('created_at', 'DESC')
            ->first();

        if (empty($survey)) {
            Flash::error('Encuesta no pertenece a experimento');
            return redirect('/');
        }


        return view('surveys.run')
            ->with('survey', $survey)
            ->with('last_survey', $last_survey)
            ->with('experiment_id', $experiment_id);
    }

    public function save_survey($experiment_id, $survey_id, Request $request)
    {

        $input = $request->all();
        $user = Auth::user();

        // Si registra múltiples respuestas
        if (isset($input['responses'])) {
            foreach ($input['responses'] as $response) {
                $item = new SurveyResponse();
                $item->test = 'unused';
                $item->label = $response['label'];
                $item->question = $response['question'];
                $item->response = $response['value'];
                $item->user_id = $user->id;
                $item->experiment_id = $experiment_id;
                $item->survey_id = $survey_id;
                $item->save();
            }
            return response()->json(['result' => 0, 'url' => route('game-instances.goto-game', $experiment_id)]);
        }

        // Si registra solo una respuesta
        if (isset($input['response'])) {
            $response = $input['response'];
            $item = new SurveyResponse();
            $item->test = 'unused';
            $item->label = isset($response['label']) ? $response['label'] : '-';
            $item->question = $response['question'];
            $item->response = isset($response['value']) ? $response['value'] : '-';
            $item->user_id = $user->id;
            $item->experiment_id = $experiment_id;
            $item->survey_id = $survey_id;
            $item->save();

            if (isset($response['action']) && $response['action'] == 'start-game') {
                return response()->json(['result' => 0, 'url' => route('game-instances.goto-game', $experiment_id)]);
            } else {
                return response()->json(['result' => 0]);
            }
        }
    }






    public function dashboard_experiment($experiment_id)
    {
        $experiment = Experiment::find($experiment_id);

        if (empty($experiment)) {
            Flash::error('Instancia de juego no encontrada');
            return redirect(route('experiments.game-instances.index', $experiment_id));
        }

        return view('dashboard.dashboard')
            ->with('experiment_id', $experiment_id);
    }
}
