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
    // perfil de usuario
    public function profile(){
        return view('user_profile.user_profile');
    }

    public function about()
    {

        $user = Auth::user();
        $userProfile = $user->userProfile;


        return view('user_profile.about',compact('user', 'userProfile'));
    }

    public function timeline()
    {
        $user = Auth::user();

        // Recupera los experimentos activos de los usuarios
        $game_instances_user_list = Experiment::leftjoin('user_experiments', 'experiments.id', '=', 'user_experiments.experiment_id')
            ->where('experiments.status', 1)
            ->where('user_experiments.user_id', $user->id);

        $game_instances_list_count = $game_instances_user_list->count();

        if ($game_instances_list_count > 1 || $game_instances_list_count == 0) {
            // Si tienes más de un experimento o ninguno, muestra el listado.
            return view('user_profile.timeline')
                ->with('game_instances_user_list', $game_instances_user_list->get());
        } else {
            return view('user_profile.timeline')
            ->with('game_instances_user_list', $game_instances_user_list->get());
        }
    }

    public function medallas()
    {
        return view('user_profile.medallas');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $userProfile = $user->userProfile;

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

         // Crear el perfil de usuario si no existe
         if (!$userProfile) {
            $userProfile = new UserProfile();
            $userProfile->user_id = $user->id;
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


