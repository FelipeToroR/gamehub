<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


use App\Models\Experiment;
use App\Models\GameExercise;
use App\Models\UserExperiment;
use App\Models\UserProfile;

use App\Models\UserGameBadge;
use App\Exports\Sheets\EvolutionPerExerciseSheet;

use App\User;

class UserProfileController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }


    // perfil de usuario
    public function profile(){

        return view('user_profile.user_profile')
            ->with('user', $this->user);
    }

    public function about()
    {
        $userProfile = $this->user->userProfile;

        return view('user_profile.about',compact('userProfile'))
            ->with('user' , $this->user);
    }

    public function timeline()
    {
        // Recupera los experimentos activos de los usuarios (ordenados desde el mas reciente)
        $game_instances_user_list = Experiment::leftjoin('user_experiments', 'experiments.id', '=', 'user_experiments.experiment_id')
            ->where('experiments.status', 1)
            ->where('user_experiments.user_id', $this->user->id)
            ->orderBy('experiments.updated_at', 'asc')
            ->get();


        $game_instances_list_count = $game_instances_user_list->count();

        if ($game_instances_list_count > 1 || $game_instances_list_count == 0) {
            // Si tienes más de un experimento o ninguno, muestra el listado.
            return view('user_profile.timeline')
                ->with('game_instances_user_list', $game_instances_user_list)
                ->with('user', $this->user);
        } else {
            return view('user_profile.timeline')
                ->with('game_instances_user_list', $game_instances_user_list)
                ->with('user', $this->user);
        }
    }

    public function medallas()
    {
        //Busca todas las medallas asociadas al usuario.
        $userBadges = UserGameBadge::with('gameBadge')->where('user_id', $this->user->id)->get();

        //Busca todos los experimentos asociados a ese usuario para calcular su desempeño
        $experiments =  $this->user->experiments;

        $usuario_experiencia[$this->user->name] = 0;

        foreach($experiments as $experiment){

            $objEvolution = new EvolutionPerExerciseSheet($experiment);
            $datosEvo = $objEvolution->query()
                        ->where('users.id', $this->user->id)
                        ->get();
            
           foreach ($datosEvo as $item) {

                $frecuencia = explode('|', $item->secuencia);
                $frecuencia_count = count($frecuencia);
    
                foreach ($frecuencia as $f) {
                    if ($f == 'B'){ // La experiencia se obtiene de sus respuestas Buenas todos lo que ha participado el usario
                    $usuario_experiencia[$this->user->name] += 10;
                    }
                }
            }
       
        }

        
        $currentPoints = $usuario_experiencia[$this->user->name];
        
        // Calcula el nivel actual y los puntos necesarios para el próximo nivel
        $level = floor($currentPoints / 100) + 1;
        $nextLevelPoints = $level * 100;
        //$progress = ($currentPoints / $nextLevelPoints) * 100;

        // Calcula el progreso en relación a los puntos del nivel actual y el siguiente nivel
        $progress = ($currentPoints - (($level - 1) * 100)) / ($nextLevelPoints - (($level - 1) * 100)) * 100;

        // Redondea el progreso a dos decimales
        $progress = round($progress, 2);

    
        return view('user_profile.medallas')
        ->with(['userBadges' => $userBadges])
        ->with('MiExperiencia' , $usuario_experiencia)
        ->with('currentPoints', $currentPoints)
        ->with('level', $level)
        ->with('nextLevelPoints', $nextLevelPoints)
        ->with('progress', $progress)
        ->with('user', $this->user);
    }

    public function update(Request $request)
    {
        $userProfile = $this->user->userProfile;

        $this->user->name = $request->input('name');
        $this->user->email = $request->input('email');
        $this->user->save();

         // Crear el perfil de usuario si no existe
         if (!$userProfile) {
            $userProfile = new UserProfile();
            $userProfile->user_id = $this->user->id;
        }

        // Actualizar los campos en el modelo UserProfile
        if ($userProfile) {
            $userProfile->description = $request->input('description');
            $userProfile->birthdate = $request->input('birthdate');
            $userProfile->region = $request->input('region');
            
            $userProfile->save();
        }
    
        return redirect()->back()->with('success', 'Perfil actualizado correctamente#scroll-target');

    }
}


