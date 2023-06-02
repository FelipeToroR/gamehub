<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Gamification\CurrencyService;
use App\Services\Gamification\ExperienceService;

use App\Charts\UserPerformanceChart;

use App\Services\EncryptService;

use App\Models\Experiment;
use App\Models\GameExercise;
use App\Models\UserExperiment;
use App\Models\UserCurrency;
use App\Models\GameBadge;
use App\Models\GameInstance;
use App\Models\UserRewardTransaction;
use App\Models\RewardDay;
use App\Models\RewardDayItem;
use App\Models\UserCurrencyTransaction;
use App\Services\Gamification\RewardService;
use Carbon\Carbon;
use Auth;
use DB;

class DashboardController extends Controller
{
    protected $experienceService;
    protected $currencyService;

    public function __construct(ExperienceService $experienceService, CurrencyService $currencyService)
    {
        $this->experienceService = $experienceService;
        $this->currencyService = $currencyService;
        $this->user = Auth::user();
    }

    /**
     * Listado de experimentos
     */
    public function index()
    {

        $user = Auth::user();

        // Recupera los experimentos activos de los usuarios
        $game_instances_user_list = Experiment::leftjoin('user_experiments', 'experiments.id', '=', 'user_experiments.experiment_id')
            ->where('experiments.status', 1)
            ->where('user_experiments.user_id', $user->id);

        $game_instances_list_count = $game_instances_user_list->count();

        if ($game_instances_list_count > 1 || $game_instances_list_count == 0) {
            // Si tienes más de un experimento o ninguno, muestra el listado.
            return view('dashboard.game-list')
                ->with('game_instances_user_list', $game_instances_user_list->get());
        } else {
            return redirect(route('dashboard.experiment', $game_instances_user_list->first()->experiment_id));
        }
    }

    /**
     * Dashboard de experimento
     */
    public function experiment_dashboard($experiment_id, RewardService $rewardService)
    {
        $user = Auth::user();

        // Recupera experimento para presentar dashboard
        $experiment_user = Experiment::leftjoin('user_experiments', 'experiments.id', '=', 'user_experiments.experiment_id')
            ->where('experiments.status', 1)
            ->where('experiments.id', $experiment_id)
            ->where('user_experiments.user_id', $user->id)
            ->select(\DB::raw('user_experiments.id as user_experiment_id, user_experiments.game_instance_id as game_instance_id, experiments.id as experiment_id, user_experiments.game_instance_id as game_instance_id'))
            ->first();

        // Recupera experimento de usuario
        $user_experiment_instance = UserExperiment::find($experiment_user->user_experiment_id); //$game_instances_user_list->first();

        // Verifica si tiene instancia de juego asignada
        if ($experiment_user->game_instance_id == null) {

            // Selecciona las instancias del experimento con menos usuarios asignados
            $assign_game_instance = GameInstance::leftjoin('user_experiments', 'game_instances.id', '=', 'user_experiments.game_instance_id')
                ->select(\DB::raw('game_instances.id as game_instance_id, COUNT(user_experiments.id) as contador'))
                ->where('game_instances.experiment_id', $user_experiment_instance->experiment_id)
                ->groupBy('game_instances.id')
                ->orderBy('contador', 'ASC')
                ->first();

            // Si la instancia no tiene juegos, lo informa.
            if (empty($assign_game_instance)) {
                echo 'No hay juegos asignados para ud. (INFO: Instancia sin juegos)';
                return;
            }

            $game_instance_id = $assign_game_instance->game_instance_id;

            // Asigna instancia de juego a experimento.
            $user_experiment_instance->game_instance_id = $assign_game_instance->id;
            $user_experiment_instance->save();
        } else {
            $game_instance_id = $experiment_user->game_instance_id;
        }

        // Calcula tiempo hasta próxima recompensa
        $now = Carbon::now();
        $end = Carbon::createFromTimeString('23:59');
        $totalDuration = $end->diffInSeconds($now);
        $totalDurationGM = Carbon::parse($totalDuration)->timestamp;

        // Comprueba si hay recompensa disponible
        $game_instance = GameInstance::find($game_instance_id);

        // Verifica que la instancia de juego tenga habilitada las recompensas 
        if($game_instance->enable_rewards == 1){
            // Si hay dias por registrar, muestra modal de recompensas
            $show_reward = (($rewardService->getLastRewardDay($user->id, $game_instance_id))->day_to_be_record != null) ? 1 : 0;
        }else{
            $show_reward = 0;
        }

        $advance_amount = UserExperiment::where('game_instance_id', $game_instance_id)
            ->where('user_id', $user->id)
            ->first();
        if (!empty($advance_amount)) {
            $advance_amount = $advance_amount->actual_responses;
        } else {
            $advance_amount = 0;
        }

        $advance_required = Experiment::find($experiment_id)->surveys
            ->whereBetween('type', [3, 4])     // Tipo de encuesta programada por ambos
            ->where('responses_expected', '>=', $advance_amount)
            ->sortBy('responses_expected')
            ->first();
        if (!empty($advance_required)) {
            $advance_required = $advance_required->responses_expected;
        } else {
            $advance_required = 9999;
        }

        // Recupera valor actual de puntajes
        $currency_amount = $this->currencyService->getUserAmount($user->id, $game_instance_id);
        $experience_amount = $this->experienceService->getUserAmount($user->id, $game_instance_id);

        // Lista de ejercicios
        $users = GameExercise::select(\DB::raw("COUNT(*) as count"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(\DB::raw("MONTH(created_at)"))
            ->pluck('count');

        // Token de cifrado
        $token = (new EncryptService())->encrypt_decrypt('encrypt', urlencode($game_instance->slug));

        # Carga medallas adquiridas por el usuario
        $badgeAcquired = GameBadge::join('user_game_badges', function ($q) use ($user, $game_instance) {
            $q->on('user_game_badges.game_badge_id', '=', 'game_badges.id')
                ->on('user_game_badges.user_id', '=', DB::raw($user->id))
                ->on('user_game_badges.game_id', '=', DB::raw($game_instance->game->id));   //
        })
            // ->where('user_game_badges.game_id', $game_instance->game->id)
            // , IF(ISNULL(user_game_badges.created_at),"0","1")
            //->select(DB::raw('game_badges.code as code, game_badges.name as name '))
            ->get();


        return view('dashboard.dashboard')
            ->with('user', $user)
            ->with('token', $token)
            ->with('currency_amount', $currency_amount)
            ->with('experience_amount', $experience_amount)
            ->with('badges', $badgeAcquired)
            ->with('show_reward', $show_reward)
            ->with('gameInstance', $game_instance)  // ok
            ->with('experiment_id', $experiment_id) // ok
            ->with('game_instance_id', $game_instance_id)   // ok
            ->with('actual_advances', $advance_amount)   // ok
            ->with('required_advances', $advance_required)   // ok
            ->with('remaining_time_next_reward', $totalDurationGM);
    }

    public function user_performance_chart(Request $request)
    {

        $input = $request->all();
        $user = Auth::user();


        // Recupera instancia a partir de token de identificación de game_instance
        $game_instance = GameInstance::findByEncryptedToken($input['game']['token']);

        $last_score_list = GameExercise::where('game_instance_id', $game_instance->id)
            ->where('user_id', $user->id)
            ->where('event', 3)
            ->where('lives', 0)
            ->orderBy('created_at', 'ASC')
            ->limit(10)
            ->get();

        $score_list = [];
        $label_list = [];
        foreach ($last_score_list as $key_score => $item_score) {
            $score_list[] = $item_score->score;
            $label_list[] = $key_score + 1;
        }

        $chart = [];
        $chart['type'] = 'line';
        $chart['data'] = [];
        $chart['data']['labels'] = $label_list;
        $chart['data']['datasets'] = [];

        // 
        $chartDataset = [];
        $chartDataset['label'] = 'Últimos puntajes';
        $chartDataset['data'] = $score_list;

        // Asigna color de fondo
        $chartDataset['backgroundColor'] = [];
        $chartDataset['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
        $chartDataset['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
        $chartDataset['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
        $chartDataset['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
        $chartDataset['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
        $chartDataset['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
        $chartDataset['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
        $chartDataset['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
        $chartDataset['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
        $chartDataset['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
        $chartDataset['borderWidth'] = 0;
        $chart['data']['datasets'][] = $chartDataset;
        $chart['options'] = [];
        $chart['options']['scales'] = [];
        $chart['options']['scales']['yAxes'] = [];
        $yAxesTicks = [];
        $yAxesTicks['ticks'] = [];
        $yAxesTicks['ticks']['beginAtZero'] = true;
        $chart['options']['scales']['yAxes'][] = $yAxesTicks;

        return response()->json(['chart' => $chart]);
    }



    /**
     * Envia petición de agregar monedas
     */
    public function push_currency(Request $request, CurrencyService $currencyService)
    {
        $user = Auth::user();
        $input = $request->all();
        $amount = $input['currency']['cost'];

        // Recupera instancia de juego a partir del token
        $game_instance_slug = (new EncryptService())->encrypt_decrypt('decrypt', urldecode($input['game']['token']));
        $gameInstance = GameInstance::where('slug', $game_instance_slug)->first();

        if (empty($gameInstance)) {
            return response()->json([
                'status' => -2,
                'message' => 'Game instance "' . $game_instance_slug . '" not found'
            ]);
        }

        $game_instance_id = $gameInstance->id;

        // Realiza transaccion de monto
        $user_currency = $currencyService->addUserAmount($user->id, $game_instance_id, ($amount * -1));

        if(empty($user_currency)){

            $current_amount = $currencyService->getUserAmount($user->id, $game_instance_id);
            return response()->json([
                'status' => 1,      // 1: Saldo insuficiente
                'currency' => $current_amount
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'currency' => $user_currency->amount
            ]);
        }
       
    }


    /**
     * Despliega recuadro de recompensas
     */
    public function reward_content(RewardService $rewardService, Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $game_instance_id = $input['game_instance_id'];
        $rewardObject = $rewardService->getReward($user->id, $game_instance_id);

        return view('rewards.display')
            ->with('rewardObject', $rewardObject)
            ->with('game_instance_id', $game_instance_id);
    }

    /**
     * Petición a solicitar recompensa
     */
    public function claim_reward(RewardService $rewardService, CurrencyService $currencyService, Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $game_instance_id = $input['game_instance_id'];
        $message = '';

        // Recupera día de última recompensa adquirida
        $current_day = $rewardService->getLastRewardDay($user->id, $game_instance_id);

        // Si el día no es el actual, permite guardar
        if (!empty($current_day->day_to_be_record)) {

            // Interpreta código de acción de <primer> ítem de recompensa
            $rewardDayItem = RewardDayItem::join('reward_days', 'reward_days.id', 'reward_day_items.reward_day_id')
                ->where('reward_days.day', $current_day->day_to_be_record)
                ->first();

            // Interpreta método de acción de ítem de bodega.
            if (!empty($rewardDayItem) && !empty($rewardDayItem->bagItemType)) {
                $rewardBagItemType = $rewardDayItem->bagItemType;
                $actions = json_decode($rewardBagItemType->actions, false);
                foreach ($actions as $action) {
                    if (isset($action->action)) {
                        $action_json = $action->action;
                        // Método de acción: 'ADD CURRENCY' agrega monto monetario
                        if (isset($action->action) && $action->action == 'ADD_CURRENCY' && isset($action->value)) {
                            $currencyService->addUserAmount($user->id, $game_instance_id, $action->value);
                            $message .= 'Has ganado G$ ' . $action->value . '. ';
                        } else if (isset($action->action) && $action->action == 'ADD_RANDOM_CURRENCY' && isset($action->min) && isset($action->max)) {
                            $random_value = rand($action->min, $action->max);
                            $currencyService->addUserAmount($user->id, $game_instance_id, $random_value);
                            $message .= 'Has ganado G$ ' . $random_value . '. ';
                        }
                    }
                }
            }

            // Almacena transacción de recompensa
            $user_reward_transaction = new UserRewardTransaction;
            $user_reward_transaction->game_instance_id = $game_instance_id;
            $user_reward_transaction->user_id = $user->id;
            $user_reward_transaction->day_counter = $current_day->day_to_be_record;
            $user_reward_transaction->created_at = Carbon::now();
            $user_reward_transaction->save();

            return response()->json(['status' => 0, 'action' => $actions, 'message' => $message]);   // Guardó correctamente

        } else {

            // Si es hoy, indica que no corresponde al día
            return response()->json(['status' => -1, 'message' => 'No corresponde al día', 'action' => null]);
        }
    }

    public function get_currency()
    {
        return response()->json(['amount' => 60]);
    }

    public function get_experience()
    {
        return response()->json(['amount' => 50]);
    }
}
