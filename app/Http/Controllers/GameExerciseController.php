<?php

namespace App\Http\Controllers;

use App\DataTables\GameExerciseDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateGameExerciseRequest;
use App\Http\Requests\UpdateGameExerciseRequest;
use App\Models\GameExercise;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class GameExerciseController extends AppBaseController
{
    /**
     * Display a listing of the GameExercise.
     *
     * @param GameExerciseDataTable $gameExerciseDataTable
     * @return Response
     */
    public function index(GameExerciseDataTable $gameExerciseDataTable)
    {
        return $gameExerciseDataTable->render('game_exercises.index');
    }

    /**
     * Show the form for creating a new GameExercise.
     *
     * @return Response
     */
    public function create()
    {
        return view('game_exercises.create');
    }

    /**
     * Store a newly created GameExercise in storage.
     *
     * @param CreateGameExerciseRequest $request
     *
     * @return Response
     */
    public function store(CreateGameExerciseRequest $request)
    {
        $input = $request->all();

        /** @var GameExercise $gameExercise */
        $gameExercise = GameExercise::create($input);

        Flash::success('Game Exercise saved successfully.');

        return redirect(route('gameExercises.index'));
    }

    /**
     * Display the specified GameExercise.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var GameExercise $gameExercise */
        $gameExercise = GameExercise::find($id);

        if (empty($gameExercise)) {
            Flash::error('Game Exercise not found');

            return redirect(route('gameExercises.index'));
        }

        return view('game_exercises.show')->with('gameExercise', $gameExercise);
    }

    /**
     * Show the form for editing the specified GameExercise.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var GameExercise $gameExercise */
        $gameExercise = GameExercise::find($id);

        if (empty($gameExercise)) {
            Flash::error('Game Exercise not found');

            return redirect(route('gameExercises.index'));
        }

        return view('game_exercises.edit')->with('gameExercise', $gameExercise);
    }

    /**
     * Update the specified GameExercise in storage.
     *
     * @param  int              $id
     * @param UpdateGameExerciseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGameExerciseRequest $request)
    {
        /** @var GameExercise $gameExercise */
        $gameExercise = GameExercise::find($id);

        if (empty($gameExercise)) {
            Flash::error('Game Exercise not found');

            return redirect(route('gameExercises.index'));
        }

        $gameExercise->fill($request->all());
        $gameExercise->save();

        Flash::success('Game Exercise updated successfully.');

        return redirect(route('gameExercises.index'));
    }

    /**
     * Remove the specified GameExercise from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var GameExercise $gameExercise */
        $gameExercise = GameExercise::find($id);

        if (empty($gameExercise)) {
            Flash::error('Game Exercise not found');

            return redirect(route('gameExercises.index'));
        }

        $gameExercise->delete();

        Flash::success('Game Exercise deleted successfully.');

        return redirect(route('gameExercises.index'));
    }
}
