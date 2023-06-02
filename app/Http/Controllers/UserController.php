<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Spatie\Permission\Models\Role;
use App\DataTables\UserDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class UserController extends AppBaseController
{
    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->toArray();
        return view('users.create')->with('role_items', $roles)->with('role_user_items', null);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        foreach ($input['user_roles'] as $role) {
            $user->assignRole($role);
        }

        Flash::success('User saved successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Carga masiva de User
     * 
     * 
     */
    public function create_batch(){

        return view('users.create_batch');
    }

    public function store_batch(Request $request){

        if ($request->hasFile('user_file')) {
            try{
                Excel::import(new UsersImport, request()->file('user_file'));
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                //Flash::error('error', $e->getMessage());

                $failures = $e->failures();

                return view('users.create_batch')
                    ->with('failures', $failures);
            }
            Flash::error('Usuarios cargados exitosamente');

            return redirect(route('users.index'));
        }else{
            Flash::error('No se pudo cargar el archivo');
            return redirect(route('users.create-batch'));

        }
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $user_roles = $user->roles->pluck('name');

        return view('users.show')
            ->with('user_roles', $user_roles)
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('Usuario no encontrado');
            return redirect(route('users.index'));
        }

        $roles = Role::pluck('name', 'name')->toArray();
        $roles_user = $user->roles->pluck('name', 'name')->toArray();

        return view('users.edit')
            ->with('role_items', $roles)
            ->with('role_user_items', $roles_user)
            ->with('user', $user);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('Usuario no encontrado');
            return redirect(route('users.index'));
        }

        $input = $request->all();

        $input_update =  [
            'name' => $input['name'],
            'first_surname' => $input['first_surname'],
            'second_surname' => $input['second_surname'],
            'email' => $input['email'],
            'course' => $input['course'],
            'course_letter' => $input['course_letter'],
            'college' => $input['college'],
            'gender' => number_format($input['gender'])
        ];

        // Solo si existe input, lo sobrescribe
        if ($request->input('password') != null) {
            $input_update['password'] = Hash::make($input['password']);
        }

        // Asigna roles
        if(isset($input['user_roles'])){
            $user->syncRoles($input['user_roles']);
        }else{
            $user->syncRoles([]);
        }

        $user->fill($input_update);
        $user->save();

        Flash::success('User updated successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $user->delete();

        Flash::success('User deleted successfully.');

        return redirect(route('users.index'));
    }


    
}
