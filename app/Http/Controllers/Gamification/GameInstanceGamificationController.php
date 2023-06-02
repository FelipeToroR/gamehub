<?php

namespace App\Http\Controllers\Gamification;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RewardController;
use App\Models\Reward;

use App\Http\Requests\UpdateGameInstanceRequestGamification;
use Illuminate\Http\Request;
use App\Models\GameInstance;
use Flash;


class GameInstanceGamificationController extends Controller
{
    
    /**
     * Show the form for editing the specified GameInstance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($experiment_id, $game_instance_id)
    {
        $gameInstance = GameInstance::find($game_instance_id);

        if (empty($gameInstance)) {
            Flash::error('Instancia de juego no encontrada');
            return redirect(route('experiments.game-instances.index', $experiment_id));
        }

        // Listado de ítemes de experimento, incluye valor nulo.
        $rewardItems = Reward::pluck('name', 'id')->toArray();
        $rewardItems[null] = 'Ninguno';

        return view('game_instances.edit_gamification')
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
    public function update($experiment_id, $game_instance_id, UpdateGameInstanceRequestGamification $request)
    {
        $gameInstance = GameInstance::find($game_instance_id);

        if (empty($gameInstance)) {
            Flash::error('Instancia de juego no encontrada');
            return redirect(route('experiments.game-instances.index', $experiment_id));
        }

        $input = $request->all();

        // Ajuste para habilitar/deshabilitar recompensas
        $input['enable_rewards'] = $request->has('enable_rewards') ? 1 : 0;
        $input['enable_performance_chart'] = $request->has('enable_performance_chart') ? 1 : 0;
        $input['enable_badges'] = $request->has('enable_badges') ? 1 : 0;
        $input['enable_leaderboard'] = $request->has('enable_leaderboard') ? 1 : 0;

        // Si no se habilita, se quita referencia a configuración de recompensa
        if($request->has('enable_rewards') == 0){
            $input['reward_id'] = null;
        }

        $gameInstance->fill($input);
        $gameInstance->save();

        Flash::success('Configuración de gamificación de instancia de juego fue actualizada satisfactoriamente.');
        return redirect(route('experiments.game-instances.index', $experiment_id));
    }
}
