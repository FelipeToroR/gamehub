<?php

namespace App\Http\Controllers;

use DB;
use App\DataTables\GameInstanceParameterDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateGameInstanceParameterRequest;
use App\Http\Requests\UpdateGameInstanceParameterRequest;
use App\Models\GameParameter;

use App\Models\Game;
use App\Models\GameInstance;
use App\Models\GameInstanceParameter;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class GameInstanceParameterController extends AppBaseController
{
    /**
     * Display a listing of the GameInstanceParameter.
     *
     * @param GameInstanceParameterDataTable $gameInstanceParameterDataTable
     * @return Response
     */
    public function index(GameInstanceParameterDataTable $gameInstanceParameterDataTable, $experiment_id, $id)
    {
        $game_instance = GameInstance::find($id);

        if (empty($game_instance)) {
            Flash::error('Instancia de parámetro de juego no encontrada');
            return redirect(route('experiments.game-instances.index', $experiment_id));
        }

        #\DB::connection()->enableQueryLog();


        # Selecciona los parámetros cruzados con los valores para esta instancia
        $list_parameters = GameInstance::join('game_parameters', 'game_instances.game_id', '=', 'game_parameters.game_id')
            ->leftjoin('game_instance_parameters', function ($q) {
                $q->on('game_parameters.id', '=', 'game_instance_parameters.game_parameter_id')
                    ->on('game_instance_parameters.game_instance_id', '=', 'game_instances.id');
            }, 'left')
            ->where('game_instances.id', '=', $id)
            ->select(DB::raw('game_parameters.id as gp_id, game_parameters.name as name, game_parameters.type as type, game_instance_parameters.id as gip_id, game_instance_parameters.name as value, game_parameters.description as description'))
            ->get();

        #$queries = \DB::getQueryLog();
        #return dd($queries);



        return $gameInstanceParameterDataTable
            ->with('experiment_id', $experiment_id)
            ->with('game_instance_id', $game_instance->id)
            ->render('game_instance_parameters.index', [
                'experiment_id' => $experiment_id,
                'game_instance' => $game_instance,
                'game_instance_id' => $game_instance->id,
                'list_parameters' => $list_parameters
            ]);
    }

    /**
     * Show the form for creating a new GameInstanceParameter.
     *
     * @return Response
     */
    public function create($experiment_id, $game_instance_id)
    {
        $game_instance = GameInstance::find($game_instance_id);

        if (empty($game_instance)) {
            Flash::error('Game instance not found');
            return redirect(route('experiments.game_instances.index', $experiment_id));
        }

        $game = $game_instance->game;
        $gameParameterItems = GameParameter::where('game_id', $game->id)->pluck('name', 'id')->toArray();

        return view('game_instance_parameters.create')
            ->with('experiment_id', $experiment_id)
            ->with('game', $game)
            ->with('gameParameterItems', $gameParameterItems)
            ->with('game_instance_id', $game_instance_id);
    }

    /**
     * Store a newly created GameInstanceParameter in storage.
     *
     * @param CreateGameInstanceParameterRequest $request
     *
     * @return Response
     */
    public function store(CreateGameInstanceParameterRequest $request, $experiment_id, $game_instance_id)
    {
        $input = $request->all();

        $game_instance = GameInstance::find($game_instance_id);

        if (empty($game_instance)) {
            Flash::error('Game instance not found');
            return redirect(route('experiments.game-instances.parameters.index', $experiment_id, $game_instance->id));
        }

        /** @var GameInstanceParameter $gameInstanceParameter */
        $gameInstanceParameter = GameInstanceParameter::create($input);

        Flash::success('Game Instance Parameter saved successfully.');

        return redirect(route('experiments.game-instances.parameters.index', [$experiment_id, $game_instance->id]));
    }

    /**
     * Display the specified GameInstanceParameter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($experiment_id, $game_instance_id, $id)
    {
        /** @var GameInstanceParameter $gameInstanceParameter */
        $gameInstanceParameter = GameInstanceParameter::find($id);

        if (empty($gameInstanceParameter)) {
            Flash::error('Game Instance Parameter not found');
            return redirect(route('experiments.game-instances.parameters.index', $experiment_id));
        }

        return view('game_instance_parameters.show')
            ->with('experiment_id', $experiment_id)
            ->with('id', $id)
            ->with('gameInstanceParameter', $gameInstanceParameter);
    }

    /**
     * Show the form for editing the specified GameInstanceParameter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($experiment_id, $game_instance_id, $id)
    {
        // Verifica que exista instancia de juego
        $game_instance = GameInstance::find($game_instance_id);
        if (empty($game_instance)) {
            Flash::error('Game instance not found');
            return redirect(route('experiments.game-instances.parameters.index', [$experiment_id, $id]));
        }

        // Verifica que exista instancia de parámetro
        $gameInstanceParameter = GameInstanceParameter::find($id);
        if (empty($gameInstanceParameter)) {
            Flash::error('Game Instance Parameter not found');
            return redirect(route('experiments.game-instances.parameters.index', [$experiment_id, $id]));
        }

        // Recupera juego
        $game = $game_instance->game;

        $gameParameterItems = GameParameter::where('game_id', $game->id)->pluck('name', 'id')->toArray();

        return view('game_instance_parameters.edit')
            ->with('experiment_id', $experiment_id)
            ->with('game_instance_id', $game_instance_id)
            ->with('game_instance_parameter_id', $id)
            ->with('gameParameterItems', $gameParameterItems)
            ->with('game', $game)
            ->with('gameInstanceParameter', $gameInstanceParameter);
    }

    /**
     * Update the specified GameInstanceParameter in storage.
     *
     * @param  int              $id
     * @param UpdateGameInstanceParameterRequest $request
     *
     * @return Response
     */
    public function update($experiment_id, $game_instance_id,  UpdateGameInstanceParameterRequest $request)
    {
        /* $gameInstanceParameter = GameInstanceParameter::find($id);
        if (empty($gameInstanceParameter)) {
            Flash::error('Game Instance Parameter not found');
            return redirect(route('experiments.game-instances.parameters.index', [$experiment_id, $game_instance_id]));
        }
        $gameInstanceParameter->fill($request->all());
        $gameInstanceParameter->save();
        */

        $arr = $request->all();

        foreach ($arr['params'] as $key => $item) {
            if ($item != null && $item['value'] != null) {
                # Verifica si existe parámetros para ítem en la instancia de juego
                $param = GameInstanceParameter::where('game_parameter_id', '=', $item['parameter_id'])
                    ->where('game_instance_id', '=', $game_instance_id)
                    ->first();
                if (!empty($param)) {
                    # Actualiza solo si el valor cambió
                    if($param->name != $item['value']){
                        $param->name = $item['value'];    // Asigna valor
                        $param->save();
                    }
                } else {
                    # $updateItem = Item::find($item['id']);
                    $newParam = new GameInstanceParameter;
                    $newParam->name = $item['value'];    // Asigna valor
                    $newParam->game_instance_id = $game_instance_id;
                    $newParam->game_parameter_id = $item['parameter_id'];
                    $newParam->save();
                }
            }
        };


        Flash::success('¡Los parámetros de la instancia de juego fueron actualizados exitosamente!.');
        return redirect(route('experiments.game-instances.parameters.index', [$experiment_id, $game_instance_id]));
    }

    /**
     * Remove the specified GameInstanceParameter from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($experiment_id, $game_instance_id, $id)
    {
        $gameInstanceParameter = GameInstanceParameter::find($id);
        if (empty($gameInstanceParameter)) {
            Flash::error('Parámetro de instancia de juego no encontrado');
            return redirect(route('experiments.game-instances.parameters.index', [$experiment_id, $game_instance_id]));
        }
        $gameInstanceParameter->delete();
        Flash::success('El parámetro de instancia de juego ha sido eliminado exitosamente');
        return redirect(route('experiments.game-instances.parameters.index', [$experiment_id, $game_instance_id]));
    }
}
