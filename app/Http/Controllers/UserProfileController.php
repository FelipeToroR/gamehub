<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;



use App\Models\Experiment;
use App\Models\GameExercise;
use App\Models\UserExperiment;
use App\Models\UserProfile;

//use App\Models\User;
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
        
        return view('user_profile.medallas')
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


