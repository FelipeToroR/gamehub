<?php

namespace App\Http\Controllers;

use App\DataTables\UserExperimentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUserExperimentRequest;
use App\Http\Requests\UpdateUserExperimentRequest;
use App\Models\UserExperiment;
use App\Models\Experiment;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class UserExperimentController extends AppBaseController
{
    /**
     * Display a listing of the UserExperiment.
     *
     * @param UserExperimentDataTable $userExperimentDataTable
     * @return Response
     */
    public function index(UserExperimentDataTable $userExperimentDataTable, $experiment_id)
    {
        $experiment = Experiment::find($experiment_id);

        if (empty($experiment)) {
            Flash::error('Experiment not found');
            return redirect(route('experiments.index'));
        }

        return $userExperimentDataTable
                ->with('experiment_id', $experiment_id)
                ->render('user_experiments.index', ['experiment_id' => $experiment_id]); //, 
    }

    /**
     * Show the form for creating a new UserExperiment.
     *
     * @return Response
     */
    public function create($experiment_id)
    {
        return view('user_experiments.create')
            ->with('experiment_id', $experiment_id);
    }

    /**
     * Store a newly created UserExperiment in storage.
     *
     * @param CreateUserExperimentRequest $request
     *
     * @return Response
     */
    public function store(CreateUserExperimentRequest $request, $experiment_id)
    {
        $input = $request->all();

        
        if($input['experiment_id'] == null){
            // Experimento es nulo, entonces hay que crear              
            $user_experiment = UserExperiment::where('user_id', $input['id'])
                ->where('experiment_id', $experiment_id)
                ->count();

            // Si ya existe, no se agrega, pero se indica que ya esta activo
            if ($user_experiment > 0) {
                return ['result' => 1];
            }

            $user_experiment = [
                'user_id' => $input['id'],
                'experiment_id' => $experiment_id,
                'game_instance_id' => null      // Hasta que juegue, se asignará su instancia automáticamente por balanceo
            ];

            UserExperiment::create($user_experiment);
            return ['result' => 1];
        }else{
            // Experimento existe, entonces hay que borrar
            $userExperiment = UserExperiment::where('experiment_id', $experiment_id)
                ->where('user_id', $input['id'])->first();

            // Si ya estaba borrado, retorna eso
            if (empty($userExperiment)) {
                return ['result' => 0];
            }

            $userExperiment->delete();

            return ['result' => 0];
        }
    }

    /**
     * Display the specified UserExperiment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($experiment_id, $id)
    {
        /** @var UserExperiment $userExperiment */
        $userExperiment = UserExperiment::find($id);

        if (empty($userExperiment)) {
            Flash::error('User Experiment not found');

            return redirect(route('experiments.users.index', $experiment_id));
        }

        return view('user_experiments.show')->with('userExperiment', $userExperiment);
    }

    /**
     * Show the form for editing the specified UserExperiment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($experiment_id, $id)
    {
        /** @var UserExperiment $userExperiment */
        $userExperiment = UserExperiment::find($id);

        if (empty($userExperiment)) {
            Flash::error('User Experiment not found');

            return redirect(route('experiments.users.index', $experiment_id));
        }

        return view('user_experiments.edit')->with('userExperiment', $userExperiment);
    }

    /**
     * Update the specified UserExperiment in storage.
     *
     * @param  int              $id
     * @param UpdateUserExperimentRequest $request
     *
     * @return Response
     */
    public function update($experiment_id, $id, UpdateUserExperimentRequest $request)
    {
        /** @var UserExperiment $userExperiment */
        $userExperiment = UserExperiment::find($id);

        if (empty($userExperiment)) {
            Flash::error('User Experiment not found');

            return redirect(route('experiments.users.index', $experiment_id));
        }

        $userExperiment->fill($request->all());
        $userExperiment->save();

        Flash::success('User Experiment updated successfully.');

        return redirect(route('experiments.users.index', $experiment_id));
    }

    /**
     * Remove the specified UserExperiment from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($experiment_id, $user_id)
    {
        /** @var UserExperiment $userExperiment */
        $userExperiment = UserExperiment::where('experiment_id',$experiment_id)
            ->where('user_id', $user_id)->first();

        if (empty($userExperiment)) {
            Flash::error('User Experiment not found');

            return redirect(route('experiments.users.index', $experiment_id));
        }

        $userExperiment->delete();

        Flash::success('User Experiment deleted successfully.');

        return redirect(route('experiments.users.index', $experiment_id));
    }
}
