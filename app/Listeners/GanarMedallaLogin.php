<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Medalla;
use Illuminate\Auth\Events\Login;

class GanarMedallaLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // Verificar condiciones :  Hacer login, durante x dias consecutivos
        // (por ahora gana la medalla cada vez que se hace login)
        // Si se cumplen las condiciones, asignar la medalla al usuario
        // modelos : Medalla y User

        $medalla = new Medalla();
        $medalla->nombre = 'Medalla de Login';
        $medalla->descripcion = 'Has ganado una medalla por hacer login';
        $medalla->save();

        $user = $event->user;
        $user->medallas()->attach($medalla->id);
    }
}
