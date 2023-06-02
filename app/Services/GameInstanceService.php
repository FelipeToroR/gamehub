<?php

namespace App\Services;

class GameInstanceService
{

    // 0: <ASOCIADO> : Se asoció experimento a usuario, pero aún no se inicia.
    // 1: <INICIADO> : Usuario esta en experimento (actualmente), aún no lo ha terminado.
    // 2: <TERMINADO> : Usuario terminó experimento.

    /**
     * Experimentos disponibles para usuario
     * @return Object Experimentos con disponibilidad para un usuario
     */
    public function getAvailableExperiments($user_id)
    {
        // Recupera listado de experimentos de usuario

    }

    public function enableExperiment($experiment_id){
        
        // Habilita experimento
        
        // Si existe al menos uno con estado <INICIADO>...
        // - Busca que tiene pendiente ese juego, para cerrar
        //   > Caso I   : Busca el juego iniciado, y ve si hay un POSTEST, y ve si cumplió la condición de cierre.
        //   > Caso II  : Busca el juego iniciado, y ve si no hay POSTEST, el juego será infinito.
        // - Informa lo pendiente el juego pendiente
        //   > Tiene un test pendiente
        //   > Si aún no se ha activado el POSTEST, entonces, 

        // Deshabilita los demás experimentos

    }
}
