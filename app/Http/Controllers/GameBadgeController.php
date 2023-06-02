<?php

namespace App\Http\Controllers;

use App\DataTables\GameBadgeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateGameBadgeRequest;
use App\Http\Requests\UpdateGameBadgeRequest;
use App\Models\GameBadge;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use File;
use DB;

class GameBadgeController extends AppBaseController
{
    /**
     * Display a listing of the GameBadge.
     *
     * @param GameBadgeDataTable $gameBadgeDataTable
     * @return Response
     */
    public function index($game_id, GameBadgeDataTable $gameBadgeDataTable)
    {
        return $gameBadgeDataTable
            ->with('game_id', $game_id)
            ->render('game_badges.index', ['game_id' => $game_id]);
    }

    /**
     * Show the form for creating a new GameBadge.
     *
     * @return Response
     */
    public function create()
    {
        return view('game_badges.create');
    }

    /**
     * Store a newly created GameBadge in storage.
     *
     * @param CreateGameBadgeRequest $request
     *
     * @return Response
     */
    public function store($game_id, CreateGameBadgeRequest $request)
    {
        $input = $request->all();
        $gameBadge = GameBadge::create($input);
        Flash::success('La medalla del juego fue guardada exitosamente.');
        return redirect(route('games.badges.index', $game_id));
    }

    public function badge_image($id)
    {
        $gameBadge = GameBadge::find($id);
        if (empty($gameBadge)) {
            return response()->json(['message' => 'Badge not found'], 404);
        }

        $g = $gameBadge->getFirstMediaPath('badges');
        //return $g[0];

        return response()->file($g);

        /* if ($g->count() > 0) {
            $path = $g[0]->getPath();
            if (!File::exists($path)) {
                return response()->json(['message' => 'File not found'], 404);
            }
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        } else {
            return response()->json(['message' => 'No badge exists'], 404);
        } */
    }

    /**
     * Display the specified GameBadge.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($game_id, $id)
    {
        /** @var GameBadge $gameBadge */
        $gameBadge = GameBadge::find($id);

        if (empty($gameBadge)) {
            Flash::error('Game Badge not found');
            return redirect(route('gameBadges.index'));
        }

        $g = $gameBadge->getMedia('badges');
        if ($g->count() > 0) {
            $url = $g[0]->getUrl();
        } else {
            $url = null;
        }

        return view('game_badges.show')
            ->with('gameBadge', $gameBadge)
            ->with('image', $url)
            ->with('game_id', $game_id);
    }

    /**
     * Show the form for editing the specified GameBadge.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var GameBadge $gameBadge */
        $gameBadge = GameBadge::find($id);

        if (empty($gameBadge)) {
            Flash::error('Game Badge not found');

            return redirect(route('gameBadges.index'));
        }

        return view('game_badges.edit')->with('gameBadge', $gameBadge);
    }

    /**
     * Update the specified GameBadge in storage.
     *
     * @param  int              $id
     * @param UpdateGameBadgeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGameBadgeRequest $request)
    {
        /** @var GameBadge $gameBadge */
        $gameBadge = GameBadge::find($id);

        if (empty($gameBadge)) {
            Flash::error('Game Badge not found');
            return redirect(route('gameBadges.index'));
        }

        $gameBadge->fill($request->all());
        $gameBadge->save();

        Flash::success('Game Badge updated successfully.');

        return redirect(route('gameBadges.index'));
    }

    /**
     * Remove the specified GameBadge from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var GameBadge $gameBadge */
        $gameBadge = GameBadge::find($id);

        if (empty($gameBadge)) {
            Flash::error('Game Badge not found');

            return redirect(route('gameBadges.index'));
        }

        $gameBadge->delete();

        Flash::success('Game Badge deleted successfully.');

        return redirect(route('gameBadges.index'));
    }
}
