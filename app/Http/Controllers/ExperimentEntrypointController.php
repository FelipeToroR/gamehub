<?php

namespace App\Http\Controllers;

use App\DataTables\ExperimentEntrypointDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateExperimentEntrypointRequest;
use App\Http\Requests\UpdateExperimentEntrypointRequest;
use App\Models\ExperimentEntrypoint;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ExperimentEntrypointController extends AppBaseController
{
    /**
     * Display a listing of the ExperimentEntrypoint.
     *
     * @param ExperimentEntrypointDataTable $experimentEntrypointDataTable
     * @return Response
     */
    public function index(ExperimentEntrypointDataTable $experimentEntrypointDataTable, $experiment_id)
    {
        return $experimentEntrypointDataTable
            ->with('experiment_id', $experiment_id)
            ->render('experiment_entrypoints.index', ['experiment_id' => $experiment_id]);
    }

    /**
     * Show the form for creating a new ExperimentEntrypoint.
     *
     * @return Response
     */
    public function create($experiment_id)
    {
        return view('experiment_entrypoints.create')
            ->with('experiment_id', $experiment_id);
    }

    /**
     * Store a newly created ExperimentEntrypoint in storage.
     *
     * @param CreateExperimentEntrypointRequest $request
     *
     * @return Response
     */
    public function store(CreateExperimentEntrypointRequest $request, $experiment_id)
    {
        $input = $request->all();
        $input['experiment_id'] = $experiment_id;
        $experimentEntrypoint = ExperimentEntrypoint::create($input);
        Flash::success('Punto de entrada de registro creado exitosamente');
        return redirect(route('experiments.entrypoints.edit', [$experiment_id, $experimentEntrypoint->token]));
    }

    /**
     * Display the specified ExperimentEntrypoint.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($experiment_id, $id)
    {
        /** @var ExperimentEntrypoint $experimentEntrypoint */
        $experimentEntrypoint = ExperimentEntrypoint::find($id);

        if (empty($experimentEntrypoint)) {
            Flash::error('Experiment Entrypoint not found');

            return redirect(route('experiments.entrypoints.index', $experiment_id));
        }

        return view('experiment_entrypoints.show')->with('experimentEntrypoint', $experimentEntrypoint);
    }

    /**
     * Show the form for editing the specified ExperimentEntrypoint.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($experiment_id, $id)
    {

        $experimentEntrypoint = ExperimentEntrypoint::find($id);

        if (empty($experimentEntrypoint)) {
            Flash::error('Experiment Entrypoint not found');
            return redirect(route('experiments.entrypoints.index', $experiment_id));
        }

        return view('experiment_entrypoints.edit')
            ->with('experiment_id', $experiment_id)
            ->with('experimentEntrypoint', $experimentEntrypoint);
    }

    /**
     * Update the specified ExperimentEntrypoint in storage.
     *
     * @param  int              $id
     * @param UpdateExperimentEntrypointRequest $request
     *
     * @return Response
     */
    public function update($experiment_id, $token, UpdateExperimentEntrypointRequest $request)
    {
      
        /** @var ExperimentEntrypoint $experimentEntrypoint */
        $experimentEntrypoint = ExperimentEntrypoint::find($token);

        if (empty($experimentEntrypoint)) {
            Flash::error('Experiment Entrypoint not found');
            return redirect(route('experiments.entrypoints.index', $experiment_id));
        }

        $input = $request->all();
        $input['experiment_id'] = $experimentEntrypoint->experiment_id;
        $experimentEntrypoint->fill($input);
        $experimentEntrypoint->save();

        Flash::success('Experiment Entrypoint updated successfully.');

        return redirect(route('experiments.entrypoints.index', $experiment_id));
    }

    /**
     * Remove the specified ExperimentEntrypoint from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ExperimentEntrypoint $experimentEntrypoint */
        $experimentEntrypoint = ExperimentEntrypoint::find($id);

        if (empty($experimentEntrypoint)) {
            Flash::error('Experiment Entrypoint not found');

            return redirect(route('experimentEntrypoints.index'));
        }

        $experimentEntrypoint->delete();

        Flash::success('Experiment Entrypoint deleted successfully.');

        return redirect(route('experimentEntrypoints.index'));
    }
}
