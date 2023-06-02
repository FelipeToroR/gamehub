<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\DataTables\GameDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\Request;

use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\GameBadge;
use App\Models\GameParameter;
use Directory;
use Response;
use File;

use Madnest\Madzipper\Madzipper;

class GameController extends AppBaseController
{
    /**
     * Display a listing of the Game.
     *
     * @param GameDataTable $gameDataTable
     * @return Response
     */
    public function index(GameDataTable $gameDataTable)
    {
        return $gameDataTable->render('games.index');
    }

    /**
     * Show the form for creating a new Game.
     *
     * @return Response
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created Game in storage.
     *
     * @param CreateGameRequest $request
     *
     * @return Response
     */
    public function store(CreateGameRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('gamefile')) {

            // Crea instancia de juego
            $game = Game::create($input);
            $game->addMediaFromRequest('gamefile')->toMediaCollection('games');
            $pathzip = $game->getMedia('games')->first()->getPath();

            // Extrae directorio html5game de proyecto GameMaker
            $zipper = new \Madnest\Madzipper\Madzipper;
            $zipper->make($pathzip)->folder('html5game')->extractTo(base_path() . '/uploads/games/' . $game->slug);

            // Recupera archivo html5game para obtener nombre de archivo .js de GameMaker
            $main_html = $zipper->make($pathzip)->getFileContent('index.html');
            preg_match_all('/html5game\/([^*]*).js/', $main_html, $m);
            $zipper->close();

            $gamedata = [];
            $gamedata['type'] = 'GM2';
            $gamedata['filename'] = $m[1][0];
            $game->extra = json_encode($gamedata);
            $game->save();

            Flash::success('Juego cargado existosamente. Crea una instancia de juego para probar el juego.');
        } else {

            Flash::error('No se pudo cargar juego');
        }

        return redirect(route('games.index'));
    }

    /**
     * Display the specified Game.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Game $game */
        $game = Game::find($id);

        if (empty($game)) {
            Flash::error('Game not found');
            return redirect(route('games.index'));
        }

        $params = Game::find($id)->parameters;  // Recordar sin ()
        $json_params = array();
        foreach ($params as $param) {
            $json_params[$param->name] = $param->type;
        }

        return view('games.show', ['game' => $game, 'jsname' => 'Dummy Conexiones', 'params' => json_encode($json_params, JSON_PRETTY_PRINT)]);
    }

    /**
     * Show the form for editing the specified Game.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Game $game */
        $game = Game::find($id);

        if (empty($game)) {
            Flash::error('Game not found');

            return redirect(route('games.index'));
        }

        return view('games.edit')->with('game', $game);
    }

    /**
     * Update the specified Game in storage.
     *
     * @param  int              $id
     * @param UpdateGameRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGameRequest $request)
    {
        $game = Game::find($id);

        if (empty($game)) {
            Flash::error('Juego no encontrado');
            return redirect(route('games.index'));
        }

        // Actualiza instancia de juego
        $game->fill($request->all());

        if ($request->hasFile('gamefile')) {
            $path = $request->file('gamefile')->store('local');
            $pathzip = storage_path('app/' . $path);

            // Extrae directorio html5game de proyecto GameMaker
            $zipper = new \Madnest\Madzipper\Madzipper;
            $path_extract = base_path() . '/uploads/games/' . $game->slug;

            if (Storage::exists($path_extract)) {
                // Borra los archivos, si existen
                (new \Illuminate\Filesystem\Filesystem)->cleanDirectory($path_extract);
            } else {
                // Crea nuevo directorio
                Storage::makeDirectory($path_extract);
            }
            // Extrae solo contenido de html5game
            $zipper->make($pathzip)->folder('html5game')->extractTo($path_extract);

            // Recupera archivo html5game para obtener nombre de archivo .js de GameMaker
            $main_html = $zipper->make($pathzip)->getFileContent('index.html');
            preg_match_all('/html5game\/([^*]*).js/', $main_html, $m);

            // Verifica si hay medallas presentes

            $gamedata = [];
            $gamedata['type'] = 'GM2';          // Por defecto, todas las importaciones son de tipo GameMaker2
            $gamedata['filename'] = $m[1][0];   // Nombre del archivo JS que carga todo.
            $game->extra = json_encode($gamedata);
            $game->save();

            // Procesa registros de medallas
            $badge_json_path = $path_extract . '/badges.json';
            if (File::exists($badge_json_path)) {
                $badge_json = File::get($badge_json_path);
                $badge_class = json_decode($badge_json);
                if (isset($badge_class->badges)) {

                    foreach ($badge_class->badges as $badge_key => $badge_item) {


                        $badge = GameBadge::where('code', $badge_key)
                            ->where('game_id', $id)->first();
                        if (!empty($badge)) {
                            $badge->name = $badge_item->name;
                            $badge->description = $badge_item->description;
                            $badge->conditions = $badge_item->conditions;
                        } else {
                            $badge = new GameBadge;
                            $badge->code = $badge_key;
                            $badge->name = $badge_item->name;
                            $badge->description = $badge_item->description;
                            $badge->conditions = $badge_item->conditions;
                            $badge->game_id = $id;
                        }
                        $badge->save();

                        // Extrae imagen correspondiente
                        $path_badge_image = $path_extract . "/badges/" . $badge_item->img;
                        if (File::exists($path_badge_image)) {

                            // Comprueba si tenía imagen asociada previamente
                            if ($badge->hasMedia('badges')) {
                                //$badge->deleteMedia('badges');
                                $badge->clearMediaCollection('badges');
                            }
                            $badge->addMedia($path_badge_image)->toMediaCollection('badges');
                            $badge->save();
                        }
                    }
                } else {
                    Flash::error('Se actualizó el juego, pero hay algunos problemas: archivo badges.json no tiene JSON válido o no contiene elemento badges en la raíz');
                }
            }
            $zipper->close();
        }

        Flash::success('Juego actualizado exitosamente');
        return redirect(route('games.index'));
    }

    /**
     * Remove the specified Game from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $game = Game::find($id);

        if (empty($game)) {
            Flash::error('Juego no encontrado');
            return redirect(route('games.index'));
        }

        $game->delete();
        Flash::success('Jueego eliminado exitosamente.');
        return redirect(route('games.index'));
    }
}
