<?php

namespace App\Services\Gamification;

use App\Models\UserExperience;
use App\Models\UserExperienceTransaction;

/**
 * Servicio de moneda virtual
 * 
 */
class ExperienceService
{

    /**
     * Recupera monto de monedas de usuario de instancia de juego actual
     */
    public function getUserAmount($user_id, $game_instance_id)
    {
        $userExperience = UserExperience::where('game_instance_id', $game_instance_id)
            ->where('user_id', $user_id)
            ->first();

        if (!empty($userExperience)) {
            $amount = $userExperience->amount;
        } else {
            $amount = 0;
        }

        return $amount;
    }
    
    public function addUserAmount($user_id, $game_instance_id, $amount)
    {
        if ($amount != 0) {
            // Verifica si existe monto para juego seleccionado
            $user_experience = UserExperience::where('game_instance_id', $game_instance_id)
                ->where('user_id', $user_id)
                ->first();

            if (empty($user_experience)) {
                // Crea registro si no existe
                $user_experience = new UserExperience;
                $user_experience->game_instance_id = $game_instance_id;
                $user_experience->user_id = $user_id;
                $user_experience->amount = $amount;
            }else{
                $user_experience->amount = ($user_experience->amount + $amount);
            }

            // Agrega monto a tabla resumen (UserCurrency)
            $user_experience->save();

            // Agrega transacción de monto
            $user_experience_transaction = new UserExperienceTransaction;
            $user_experience_transaction->user_experience_id = $user_experience->id;
            $user_experience_transaction->amount = $amount;
            $user_experience_transaction->save();
            return $user_experience;
        } else {
            return null;
        }
    }
}