<?php

namespace App\Http\Controllers;

use App\DataTables\SurveyDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Models\Survey;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SurveyController extends AppBaseController
{
    /**
     * Display a listing of the Survey.
     *
     * @param SurveyDataTable $surveyDataTable
     * @return Response
     */
    public function index(SurveyDataTable $surveyDataTable, $experiment_id)
    {
        return $surveyDataTable
            ->with('experiment_id', $experiment_id)
            ->render('surveys.index', ['experiment_id'=> $experiment_id]);
    }

    /**
     * Show the form for creating a new Survey.
     *
     * @return Response
     */
    public function create($experiment_id)
    {
        return view('surveys.create')->with('experiment_id', $experiment_id);
    }

    /**
     * Store a newly created Survey in storage.
     *
     * @param CreateSurveyRequest $request
     *
     * @return Response
     */
    public function store(CreateSurveyRequest $request, $experiment_id)
    {
        $input = $request->all();

        /** @var Survey $survey */
        $input['experiment_id'] = $experiment_id;
        $survey = Survey::create($input);

        Flash::success('Survey saved successfully.');

        return redirect(route('experiments.surveys.index', $experiment_id));
    }

    /**
     * Display the specified Survey.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($experiment_id, $id)
    {
        /** @var Survey $survey */
        $survey = Survey::find($id);

        if (empty($survey)) {
            Flash::error('Survey not found');

            return redirect(route('experiments.surveys.index', $experiment_id));
        }

        return view('surveys.show')->with('survey', $survey)->with('experiment_id', $experiment_id);
    }

    /**
     * Show the form for editing the specified Survey.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($experiment_id, $id)
    {
        $survey = Survey::find($id);

        if (empty($survey)) {
            Flash::error('Cuestionario no encontrado');
            return redirect(route('experiments.surveys.index', $experiment_id));
        }

        // Reconvierte formatos
        if(!empty($survey->initial_date)){
            $survey->initial_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $survey->initial_date)->toDateString();
        }
        if(!empty($survey->end_date)){
            $survey->end_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $survey->end_date)->toDateString();
        }
        return view('surveys.edit')->with('survey', $survey)->with('experiment_id', $experiment_id);
    }

    /**
     * Update the specified Survey in storage.
     *
     * @param  int              $id
     * @param UpdateSurveyRequest $request
     *
     * @return Response
     */
    public function update($experiment_id, $id, UpdateSurveyRequest $request)
    {
        $survey = Survey::find($id);

        if (empty($survey)) {
            Flash::error('Survey not found');
            return redirect(route('experiments.surveys.index', $experiment_id));
        }


        $survey->fill($request->all());
        $survey->save();

        Flash::success('Survey updated successfully.');
        return redirect(route('experiments.surveys.index', $experiment_id));
    }

    /**
     * Remove the specified Survey from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($experiment_id, $id)
    {
        /** @var Survey $survey */
        $survey = Survey::find($id);

        if (empty($survey)) {
            Flash::error('Survey not found');
            return redirect(route('experiments.surveys.index', $experiment_id));
        }

        $survey->delete();

        Flash::success('Survey deleted successfully.');

        return redirect(route('experiments.surveys.index', $experiment_id));
    }
}
