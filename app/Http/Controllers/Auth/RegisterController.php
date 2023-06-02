<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Models\ExperimentEntrypoint;
use App\Models\UserExperiment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $customAttributes = [
            'name' => 'nombres',
            'first_surname' => 'apellido paterno',
            'second_surname' => 'apellido materno',
            'gender' => 'género',
            'course' => 'curso',
            'course_letter' => 'letra del curso',
            'college' => 'colegio'
        ];

        $messages = [
            'required' => 'El campo :attribute es requerido.',
            
        ];

        $v =  Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'first_surname' => ['required', 'string', 'max:255'],
            'second_surname' => ['nullable','string', 'max:255'],
            'gender' => ['required', 'string', 'max:1'],
            'course' => ['required', 'string', 'max:255'],
            'course_letter' => ['nullable', 'string', 'max:50'],
            'college' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'token' => ['required', 'string', 'max:30']
        ], $messages, $customAttributes);


        return $v;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $LEARNER_ROLE_ID = 2;

        $new_user = User::create([
            'name' => $data['name'],
            'first_surname' => $data['first_surname'],
            'second_surname' => $data['first_surname'],
            'gender' => $data['gender'],
            'course' => $data['course'],
            'course_letter' => $data['course_letter'],
            'college' => $data['college'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'experiment_endpoint_token' => $data['token']
        ]);

        // Asigna rol de aprendiz
        $new_user->assignRole('learner');

        return $new_user;
    }


    public function showRegistrationForm($code = null, Request $request)
    {
        $params = $request->code;
        if (empty($params)) {
            // Registra usuario normal (externo)
            return view('auth.register');
        } else {
            // Registra usuario basado en código
            $entrypoint = ExperimentEntrypoint::find($params);
            if (!empty($entrypoint)) {
                return view('auth.register_by_code')
                    ->with('entrypoint', $entrypoint);
            } else {
                return null;
            }
        }
    }


    protected function registered(Request $request, $user)
    {
        $params = $request->code;

        $entrypoint = ExperimentEntrypoint::find($params);

        // Asigna experimento a realizar
        $user_experiment = [
            'user_id' => $user->id,
            'experiment_id' => $entrypoint->experiment_id,
            'game_instance_id' => null      // Hasta que juegue, se asignará su instancia automáticamente por balanceo
        ];

        UserExperiment::create($user_experiment);

        return;
    }
}
