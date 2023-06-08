<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('dashboard.index'));
});

/** Autenticación y registro de usuarios*/
Auth::routes(['verify' => true]);
Route::get('register/{code}', 'Auth\RegisterController@showRegistrationForm')->name('register.code');
Route::get('login/{code}', 'Auth\LoginController@showLoginForm')->name('login.code');
Route::get('code/{code}', 'Auth\LoginController@showLinkerForm')->name('code');


Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

/** Juegos */
Route::resource('games', 'GameController')->middleware('verified');
Route::resource('games.badges', 'GameBadgeController')->middleware('verified');
Route::get('badges/{badge}/image', 'GameBadgeController@badge_image')->middleware('verified');
Route::resource('games.parameters', 'GameParameterController')->middleware('verified');

// Corrige falla de GM que asume que recursos estan en el mismo directorio.

// (?)
Route::get('/users/me', 'UserController@me')->name('user.me')->middleware('verified');



/** Catálogo de juegos */
Route::get('/catalog', 'GameCatalogController@index')->name('game.catalog')->middleware('verified');
Route::get('/catalog/{gameId}/details', 'GameCatalogController@details')->name('game.details')->middleware('verified');

// (?)
Route::get('/url/getUrl.php', 'GameCatalogController@url')->name('game-catalog.url')->middleware('verified');

/** Catálogo de juegos */
Route::get('/catalog/test/1/game/{gameid}/details', 'GameCatalogController@test')->name('game-catalog.test')->middleware('verified');
Route::get('/catalog/{gameId}/play', 'GameCatalogController@play')->where('gameId', '[0-9]+')->name('game.play')->middleware('verified');

/** Acceso a archivos dependientes de juegos de GameMaker 2 */
// Ruta para rescatar archivos de recursos de GameMaker
Route::get('/catalog/{gameSlug}/{filename}', function($gameSlug, $filename){
    $path = app_path() . '/../uploads/games/1/' . $filename;
    $game = \App\Models\Game::where('slug', $gameSlug)->firstOrFail(); 
    if(!File::exists($path)) {
        return response()->json(['message' => 'File not found.', 'path' => $path, 'filename' => $filename], 404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->where('filename', '(.*)')->middleware('verified');

// Ruta para rescatar archivos de recursos desde SHOW (?)
Route::get('/games/{gameId}/{filename}', function($gameId, $filename){
    // FIX: gm no usa rutas absolutas, por tanto hay que subsanarlo
    if (substr($filename, 0, strlen('html5game')) == 'html5game') {
        $filename = substr($filename, strlen('html5game'));
    }
    $path = base_path() . '/uploads/' . $gameId . '/'. $filename;
    $game = \App\Models\Game::where('id', $gameId)->firstOrFail(); 
    if(!File::exists($path)) {
        return response()->json(['message' => 'File not found.', 'path' => $path, 'filename' => $filename], 404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->where('filename', '(.*)')->middleware('verified');


/** Experimentos */
Route::resource('experiments', 'ExperimentController')->middleware('verified');
Route::resource('experiments.users', 'UserExperimentController')->middleware('verified');
Route::resource('experiments.entrypoints', 'ExperimentEntrypointController')->middleware('verified');

/** Instancias de juego */
Route::resource('experiments.game-instances', 'GameInstanceController')->middleware('verified');
Route::get('/experiment/{experiment_id}/game-instances/{game_instance}/gamification', 'Gamification\GameInstanceGamificationController@edit')->name('experiments.game-instances.gamification.edit')->middleware('verified');
Route::patch('/experiment/{experiment_id}/game-instances/{game_instance}/gamification', 'Gamification\GameInstanceGamificationController@update')->name('experiments.game-instances.gamification.update')->middleware('verified');
Route::resource('experiments.game-instances.parameters', 'GameInstanceParameterController')->only(['index'])->middleware('verified');
Route::put('experiments/{experiment}/game-instances/{game_instance}/parameters', 'GameInstanceParameterController@update')->name('experiments.game-instances.parameters.update');

/** Encuestas pre y postest */
Route::resource('experiments.surveys', 'SurveyController')->middleware('verified');
Route::get('/experiment/{experiment_id}/survey/{survey_id}/run', 'GameInstanceController@test_survey')->name('survey.run')->middleware('verified');
Route::post('/experiment/{experiment_id}/survey/{survey_id}', 'GameInstanceController@save_survey')->name('survey.save')->middleware('verified');


/** Reportes */
Route::get('/experiments/{experiment_id}/reports', 'ExperimentController@report')->name('experiments.reports')->middleware('verified');
Route::get('/experiments/{experiment_id}/reports/consolidated', 'ExperimentController@report_consolidated_performance')->name('experiments.reports.consolidated')->middleware('verified');
Route::get('/experiments/{experiment_id}/reports/tests', 'ExperimentController@report_tests_results')->name('experiments.reports.tests')->middleware('verified');
Route::get('/experiments/{experiment_id}/reports/summary', 'ExperimentController@report_summary')->name('experiments.reports.summary')->middleware('verified');
Route::get('/experiments/{experiment_id}/reports/performance-per-user', 'ExperimentController@report_performance')->name('experiments.reports.performance')->middleware('verified');
Route::get('/experiments/{experiment_id}/reports/time-per-user', 'ExperimentController@report_time')->name('experiments.reports.time')->middleware('verified');

/** Tabla de puntajes */
Route::get('/experiment/{experiment_id}/leaderboard', 'GameInstanceController@score_list')->name('game-instances.leaderboard')->middleware('verified');

/** Dashboard */
# Listado de experimentos disponibles para usuario 
Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index')->middleware('verified');
Route::get('/dashboard/{experiment_id}', 'DashboardController@experiment_dashboard')->name('dashboard.experiment')->middleware('verified');
Route::get('/dashboard/performance/chart', 'DashboardController@user_performance_chart')->name('dashboard.performance')->middleware('verified');




Route::get('/experiment/play-game/{experiment_id}', 'GameInstanceController@goto_game_instance')->name('game-instances.goto-game')->middleware('verified');




/** Métodos de usuario */
Route::get('/game-instances/{game_id}/{game_instance_id}/play', 'GameInstanceController@play')->name('game-instances.play')->middleware('verified');
Route::post('/game-instances/data/load', 'GameInstanceController@initial_params')->name('game-instances.load-data')->middleware('verified');
Route::post('/game-instances/data/save', 'GameInstanceController@save_data')->name('game-instances.save-data')->middleware('verified');

// Surveys






// Ruta para rescatar archivos de recursos desde SHOW
Route::get('/game-instances/{game_id}/{game_instance_id}/{filename}', function($gameId, $gameInstanceId, $filename){
    
    // FIX: gm no usa rutas absolutas, por tanto hay que subsanarlo
    if (substr($filename, 0, strlen('html5game')) == 'html5game') {
        $filename = substr($filename, strlen('html5game'));
    }

    $path = base_path() . '/uploads/games/' . $gameId . '/' . $filename ; //'/uploads/' . $gameId . '/'. $filename;
    //$game = \App\Models\Game::where('id', $gameId)->firstOrFail(); 

    if(!File::exists($path)) {
        return response()->json(['message' => 'File not found.', 'path' => $path, 'filename' => $filename], 404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
    
})->where('filename', '(.*)')->middleware('verified');



Route::resource('users', 'UserController')->middleware('verified');
Route::get('/users/create/batch', 'UserController@create_batch')->name('users.create-batch')->middleware('verified');
Route::post('/users/create/batch', 'UserController@store_batch')->name('users.store-batch')->middleware('verified');


/** Gamificación — Puntaje: Monedas y experiencia */
Route::get('/scores/personal', 'UserController@create_batch')->name('scores.get')->middleware('verified');
Route::post('/game-instances/shop/buy', 'DashboardController@push_currency')->name('scores.currency.buy')->middleware('verified');

/** Gamificación — Recompensas */
Route::resource('rewards', 'RewardController')->middleware('verified');
Route::resource('rewards.days', 'RewardDayController')->middleware('verified');
Route::resource('rewards.days.items', 'RewardDayItemController')->middleware('verified');
Route::post('/rewards/transaction/{game_instance_id}/process', 'GameInstanceController@add_day_reward')->name('rewards.request')->middleware('verified');
Route::post('/rewards/transaction/modal', 'DashboardController@reward_content')->name('rewards.modal')->middleware('verified');
Route::post('/rewards/transaction/request', 'DashboardController@claim_reward')->name('rewards.request')->middleware('verified');

/** Gamificación — Bolsa de ítemes */
Route::resource('bagItemTypes', 'BagItemTypeController');
Route::resource('userBagItems', 'UserBagItemController');



Route::get('chart', 'DashboardController@user_performance_chart');

/** Perfil de usuario */
Route::get('/user_profile', 'UserProfileController@profile')->name('user_profile.user_profile')->middleware('verified');

Route::get('/user_profile/about'   , 'UserProfileController@about')->name('user_profile.about')->middleware('verified');
Route::get('/user_profile/timeline', 'UserProfileController@timeline')->name('user_profile.timeline')->middleware('verified');
Route::get('/user_profile/medallas', 'UserProfileController@medallas')->name('user_profile.medallas')->middleware('verified');



Route::put('/user_profile/update', 'UserProfileController@update')->name('user_profile.update');


/** Mostrar grafico del tiempo usado por en cada instancia */

Route::get('/tiempo_x_instancias', 'TiempoXInstanciaController@index')->name('tiempo_x_instancias.index')->middleware('verified');

Route::post('/tiempo_x_instancias/listar_instancias', 'TiempoXInstanciaController@listarInstanciasAsociadas')->name('tiempo_x_instancias.listar_instancias')->middleware('verified');
//Route::get('/tiempo_x_instancias/listar_instancias', 'TiempoXInstanciaController@listarInstanciasAsociadas')->name('tiempo_x_instancias.listar_instancias')->middleware('verified');

Route::get('/tiempo_x_instancias/grafico_instancia/{id}', 'TiempoXInstanciaController@showgraphic')->name('tiempo_x_instancias.grafico_instancia')->middleware('verified');

Route::get('/tiempo_x_instancias/comparar_instancias/{id}', 'TiempoXInstanciaController@compararInstancias')->name('tiempo_x_instancias.comparar_instancias')->middleware('verified');

Route::get('/rendimiento_grupos', 'RendimientoGrupoController@index')->name('rendimiento_grupos.index')->middleware('verified');




