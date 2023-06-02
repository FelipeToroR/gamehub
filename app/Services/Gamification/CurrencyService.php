<?php

namespace App\Services\Gamification;


use App\Models\UserCurrency;
use App\Models\UserCurrencyTransaction;

/**
 * Servicio de moneda virtual
 * 
 */
class CurrencyService
{

    /**
     * Recupera monto de monedas de usuario de instancia de juego actual
     */
    public function getUserAmount($user_id, $game_instance_id)
    {
        $userCurrency = UserCurrency::where('game_instance_id', $game_instance_id)
            ->where('user_id', $user_id)
            ->first();

        if (!empty($userCurrency)) {
            $amount = $userCurrency->amount;
        } else {
            $amount = 0;
        }
        return $amount;
    }

    /**
     * Agrega monto a servicio
     */
    public function addUserAmount($user_id, $game_instance_id, $amount)
    {

        if ($amount != 0) {
            // Verifica si existe monto para juego seleccionado
            $user_currency = UserCurrency::where('game_instance_id', $game_instance_id)
                ->where('user_id', $user_id)
                ->first();

            if (empty($user_currency)) {
                // Crea registro si no existe
                $user_currency = new UserCurrency;
                $user_currency->game_instance_id = $game_instance_id;
                $user_currency->user_id = $user_id;
                if($amount < 0){
                    // Si monto es negativo rechaza compra, debido a que no tiene dinero.
                    return null;
                }else{
                    // Si monto positivo, agrega (sin límites)
                    $user_currency->amount = $amount;
                }
            }

            // Agrega monto a tabla resumen (UserCurrency)
            if($amount < 0){
                if($user_currency->amount + $amount >= 0){
                    $user_currency->amount = ($user_currency->amount + $amount);
                }else{
                    return null;    // Si excede monto, rechaza transacción
                }
            }else{
                // Si es positivo, no hay límites
                $user_currency->amount = ($user_currency->amount + $amount);    
            }
            
            $user_currency->save();

            // Agrega transacción de monto
            $user_currency_transaction = new UserCurrencyTransaction;
            $user_currency_transaction->user_currency_id = $user_currency->id;

            if ($amount > 0) {
                $user_currency_transaction->amount = $amount;
                $user_currency_transaction->operation = 'DEBIT';    // 'DEBIT' agrega
            } else {
                $user_currency_transaction->amount = ($amount * -1);
                $user_currency_transaction->operation = 'CREDIT';    // 'CREDIT' retiro
            }
            $user_currency_transaction->save();

            return $user_currency;
        } else {
            return null;
        }
    }
}
