<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\ExperimentEntrypoint;
use App\Models\UserExperiment;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm($code = null, Request $request)
    {
        $params = $request->code;
        if (empty($params)) {
            // Iniciar sesión normal (externo)
            return view('auth.login');
        } else {
            // Iniciar sesión como usuario basado en código
            $entrypoint = ExperimentEntrypoint::find($params);
            if (!empty($entrypoint)) {
                return view('auth.login_by_code')
                    ->with('code', $code)
                    ->with('entrypoint', $entrypoint);
            } else {
                return null;
            }
        }
    }

    public function showLinkerForm($code = null, Request $request)
    {
        $params = $request->code;
        if (!empty($params)) {
            // Iniciar sesión como usuario basado en código
            $entrypoint = ExperimentEntrypoint::find($params);
            if (!empty($entrypoint)) {
                return view('auth.linker_by_code')
                    ->with('code', $code)
                    ->with('entrypoint', $entrypoint);
            } else {
                return null;
            }
        }
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $params = $request->code;

        if(!empty($params)){

            $entrypoint = ExperimentEntrypoint::find($params);

            // Comprueba que ya no tenga asociado previamente el experimento
            $user_experiment = UserExperiment::where('user_id', $user->id)
                ->where('experiment_id', $entrypoint->experiment_id)
                ->first();

            if (empty($user_experiment)) {

                // Asigna experimento a realizar
                $user_experiment = [
                    'user_id' => $user->id,
                    'experiment_id' => $entrypoint->experiment_id,
                    'game_instance_id' => null      // Hasta que juegue, se asignará su instancia automáticamente por balanceo
                ];

                // Asigna nuevo experimento
                UserExperiment::create($user_experiment);

            }

        }
        return;
    }
}
