<?php

namespace App\Http\Controllers;

use App\DataTables\GameParameterDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateGameParameterRequest;
use App\Http\Requests\UpdateGameParameterRequest;
use App\Models\GameParameter;
use App\Models\Game;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class GameParameterController extends AppBaseController
{
    /**
     * Display a listing of the GameParameter.
     *
     * @param GameParameterDataTable $gameParameterDataTable
     * @return Response
     */
    public function index(GameParameterDataTable $gameParameterDataTable, $game_id)
    {
        $game = Game::find($game_id);

        if (empty($game)) {
            Flash::error('Juego no encontrado');
            return redirect(route('games.index'));
        }

      

        //where('game_id', $game->id)
        //$gameParameterDataTable->eloquent(GameParameter::query())->toJson();
       // $gameParameterDataTable->queryBuilder($GameParameter::query())->toJson();

       return $gameParameterDataTable
            ->with('game_id', $game->id)
            ->render('game_parameters.index', ['game' => $game, 'game_id' => $game->id]);
    }

    /**
     * Show the form for creating a new GameParameter.
     *
     * @return Response
     */
    public function create($game_id)
    {
        return view('game_parameters.create')
            ->with('game_id', $game_id);
          
    }

    /**
     * Store a newly created GameParameter in storage.
     *
     * @param CreateGameParameterRequest $request
     *
     * @return Response
     */
    public function store(CreateGameParameterRequest $request, $game_id)
    {
        $input = $request->all();

        $game = Game::find($game_id);

        if (empty($game)) {
            Flash::error('Game not found');
            return redirect(route('game.index'));
        }

        $input['game_id'] = $game_id;
        $gameParameter = GameParameter::create($input);

        Flash::success('Game Parameter saved successfully.');

        return redirect(route('games.parameters.index', $game->id));
    }

    /**
     * Display the specified GameParameter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($game_id, $id)
    {
        /** @var GameParameter $gameParameter */
        $gameParameter = GameParameter::find($id);

        if (empty($gameParameter)) {
            Flash::error('Game Parameter not found');

            return redirect(route('game-parameters.index'));
        }

        return view('game_parameters.show')->with('game_id', $game_id)->with('gameParameter', $gameParameter);
    }

    /**
     * Show the form for editing the specified GameParameter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($game_id, $id)
    {
        $game = Game::find($game_id);

        if (empty($game)) {
            Flash::error('Juego no encontrado');
            return redirect(route('games.index'));
        }
        
        $gameParameter = GameParameter::find($id);

        if (empty($gameParameter)) {
            Flash::error('Parámetro de juego no encontrado');
            return redirect(route('games.parameters.index', $game_id));
        }

        return view('game_parameters.edit')
            ->with('game_id', $game_id)
            ->with('gameParameter', $gameParameter);
    }

    /**
     * Update the specified GameParameter in storage.
     *
     * @param  int              $id
     * @param UpdateGameParameterRequest $request
     *
     * @return Response
     */
    public function update($game_id, $id, UpdateGameParameterRequest $request)
    {
        /** @var GameParameter $gameParameter */
        $gameParameter = GameParameter::find($id);

        if (empty($gameParameter)) {
            Flash::error('Game Parameter not found');

            return redirect(route('games.parameters.index', $id));
        }

        $gameParameter->fill($request->all());
        $gameParameter->save();

        Flash::success('Game Parameter updated successfully.');

        return redirect(route('games.parameters.index', $game_id));
    }

    /**
     * Remove the specified GameParameter from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($game_id, $id)
    {
        /** @var GameParameter $gameParameter */
        $gameParameter = GameParameter::find($id);

        if (empty($gameParameter)) {
            Flash::error('Game Parameter not found');

            return redirect(route('games.parameters.index', $game_id));
        }

        $gameParameter->delete();

        Flash::success('Game Parameter deleted successfully.');

        return redirect(route('games.parameters.index', $game_id));
    }
}
