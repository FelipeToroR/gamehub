<?php

namespace App\Services\Gamification;

use Carbon\Carbon;
use App\Models\GameInstance;
use App\Models\RewardDay;
use App\Models\RewardDayItem;
use App\Models\UserRewardTransaction;

/**
 * Servicio de moneda virtual
 * 
 */
class RewardService
{
    /* protected $game_instance_id;

    public function __construct($game_instance_id){
        $this->game_instance_id = $game_instance_id;
    }*/

    /**
     * Recupera recompensa actual para usuario
     */
    public function getReward($user_id, $game_instance_id)
    {

        // Recupera recompensa desde game_instance_id
        $gameInstance = GameInstance::find($game_instance_id);

        if (!empty($gameInstance)) {

            // Recupera registros de día para instancia de juego asociado
            $reward_days = RewardDay::where('reward_id', $gameInstance->reward_id)->orderBy('day', 'ASC')->get();
            $reward_object['list'] = [];

            $lastRewardDay = $this->getLastRewardDay($user_id, $game_instance_id);

            if (empty($lastRewardDay->day_to_be_record)) {
                $reward_object['message'] = '¡No hay nada que reclamar!';
            } else {
                $reward_object['message'] = 'Reclama tu recompensa por ser tu #' . $lastRewardDay->day_to_be_record . ' día consecutivo';
            }

            ///'DÍA POR REGISTRAR: ' . $lastRewardDay->day_to_be_record . ' DÍA ÚLT REGISTRADO: ' . $lastRewardDay->last_recorded_day;

            foreach ($reward_days as $key => $day_value) {

                $day = $day_value->day;
                $newitem[$day_value->day]['day'] = $day_value->day;

                // Recupera primer ítem por día
                $reward_item = RewardDayItem::where('reward_day_id', $day_value->id)->first();

                if (!empty($reward_item)) {
                    $newitem[$day_value->day]['quantity'] = $reward_item->quantity;
                    $newitem[$day_value->day]['name'] = $reward_item->bagItemType->name;
                    $newitem[$day_value->day]['actions'] = $reward_item->bagItemType->actions;
                } else {
                    // Si no hay premios asignados
                    $newitem[$day_value->day]['quantity'] = 0;
                    $newitem[$day_value->day]['name'] = 'Sin premios';
                    $newitem[$day_value->day]['actions'] = null;
                }

                if (empty($lastRewardDay->day_to_be_record)) {

                    $newitem[$day_value->day]['class'] = 'disabled';
                } else {
                    if ($day < $lastRewardDay->day_to_be_record) {
                        $newitem[$day_value->day]['class'] = 'disabled';
                    } else if ($day > $lastRewardDay->day_to_be_record) {
                        $newitem[$day_value->day]['class'] = 'normal';
                    } else {
                        $newitem[$day_value->day]['class'] = 'active';
                    }
                }
                $reward_object['list'] = (object) $newitem;
            }
        }

        return (object) $reward_object;
    }

    /**
     * Recupera el dia actual de recompensa
     * @return array 'last_day' Último día registrado (mientras saved=true)
     *               'current_day' Día actual, respecto a último día registrado
     *               'saved' Indica si last_day esta almacenado en BD
     *               'now': Indica si el último día registrado es el actual
     */
    public function getLastRewardDay($user_id, $game_instance_id)
    {
        // TODO: Ver el caso cuando se salta días (ahi muere xd)

        // Busca último día
        $last_day = UserRewardTransaction::where('game_instance_id', $game_instance_id)
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->first();

        if (!empty($last_day)) {
            $last_date = Carbon::parse($last_day->created_at)->toDateString();
            $current_date = Carbon::now()->toDateString();
            $is_now = ($last_date == $current_date);    // ... además es el mismo día
            $diffDays = Carbon::parse($last_date)->diffInDays(Carbon::now());
            $now = $is_now;

            // Si existe algo último día registrado
            $last_recorded_day = $last_day->day_counter;
            $current_day_from_last = ($last_day->day_counter + $diffDays);

            // Verifica si es el mismo día que último registrado y es hoy
            if ($diffDays == 0) {
                // Es el mismo día
                $day_to_be_record = null;
            } else if ($diffDays == 1) {
                // Pasó un día, registra día siguiente
                $day_to_be_record = $last_day->day_counter + 1;
            } else if ($diffDays > 1) {
                // Pasó mas de un día, resetear contador
                $day_to_be_record = 1;
            }

            $saved = true;
        } else {
            // Si es la primera vez, retorna 1.
            $last_recorded_day = null;
            $current_day_from_last = 1;   // Es día 1, si no hay previos
            $day_to_be_record = 1;
            $saved = false;
            $reward_items = null;
        }

        // Necesito
        // day_to_be_recorded: Día a registrar, null si no hay que registrar por que ya se registró
        // last_recorded_data: Último día registrado, null si nunca se ha registrado para usuario
        return (object) [

            'day_to_be_record' => $day_to_be_record,
            'last_recorded_day' => $last_recorded_day /*, 'items' => $reward_items */
        ];
    }

    /**
     * Envia petición para agregar recompensa del día
     */
    private function pushReward()
    {
    }
}
