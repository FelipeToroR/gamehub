<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\GameInstance;
use App\Models\Experiment;

class HomeController extends Controller
{
    /**
     * Crea una nueva instancia controladora
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Instancia principal 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Recupera los experimentos activos de los usuarios
        $game_instances_user_list = Experiment::leftjoin('user_experiments', 'experiments.id', '=', 'user_experiments.experiment_id')
            ->where('experiments.status', 1)
            ->where('user_experiments.user_id', $user->id);

        $game_instances_list_count = $game_instances_user_list->count();

        if ($game_instances_list_count > 1 || $game_instances_list_count == 0) {
            // Si tienes más de un experimento o ninguno
            return view('home')
                ->with('game_instances_user_list', $game_instances_user_list->get());
        } else {
            // Si tienes solo un experimento, accede directamente a elegir instancia
            return redirect(route('dashboard.experiment', $game_instances_user_list->get()->get(0)->experiment_id));
        }
    }
}
