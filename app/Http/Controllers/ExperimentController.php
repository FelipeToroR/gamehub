<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use App\DataTables\ExperimentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateExperimentRequest;
use App\Http\Requests\UpdateExperimentRequest;
use App\Models\Experiment;
use App\User;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Exports\ExperimentExport;
use App\Exports\ConsolidatedExperimentExport;
use App\Exports\TestsResultsExport;
use App\Models\GameExercise;
use Maatwebsite\Excel\Facades\Excel;

class ExperimentController extends AppBaseController
{
    /**
     * Display a listing of the Experiment.
     *
     * @param ExperimentDataTable $experimentDataTable
     * @return Response
     */
    public function index(ExperimentDataTable $experimentDataTable)
    {
        return $experimentDataTable->render('experiments.index');
    }

    /**
     * Show the form for creating a new Experiment.
     *
     * @return Response
     */
    public function create()
    {
        return view('experiments.create');
    }

    /**
     * Store a newly created Experiment in storage.
     *
     * @param CreateExperimentRequest $request
     *
     * @return Response
     */
    public function store(CreateExperimentRequest $request)
    {
        $input = $request->all();

        /** @var Experiment $experiment */
        $experiment = Experiment::create($input);

        Flash::success('Experimento almacenado exitosamente');

        return redirect(route('experiments.index'));
    }

    /**
     * Display the specified Experiment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Experiment $experiment */
        $experiment = Experiment::find($id);

        if (empty($experiment)) {
            Flash::error('Experimento no encontrado');
            return redirect(route('experiments.index'));
        }

        return view('experiments.show')->with('experiment', $experiment);
    }

    /**
     * Show the form for editing the specified Experiment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Experiment $experiment */
        $experiment = Experiment::find($id);

        if (empty($experiment)) {
            Flash::error('Experimento no encontrado');

            return redirect(route('experiments.index'));
        }

        return view('experiments.edit')->with('experiment', $experiment);
    }

    /**
     * Update the specified Experiment in storage.
     *
     * @param  int              $id
     * @param UpdateExperimentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExperimentRequest $request)
    {
        $experiment = Experiment::find($id);

        if (empty($experiment)) {
            Flash::error('Experimento no encontrado');

            return redirect(route('experiments.index'));
        }

        $experiment->fill($request->all());
        $experiment->save();

        Flash::success('Experimento actualizado exitosamente.');

        return redirect(route('experiments.index'));
    }

    /**
     * Remove the specified Experiment from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $experiment = Experiment::find($id);

        if (empty($experiment)) {
            Flash::error('Experimento no encontrado');
            return redirect(route('experiments.index'));
        }

        if($experiment->status == '1'){
            Flash::error('No se pudo detener el experimento. Debe detenerlo antes de eliminar un experimento.');
            return redirect(route('experiments.index'));
        }

        $experiment->delete();
        Flash::success('Experimento eliminado exitosamente.');

        return redirect(route('experiments.index'));
    }

    /**
     * Genera reportes por experimento
     */
    public function report($experiment_id)
    {

        return Excel::download(new ExperimentExport($experiment_id), 'users.xlsx');
    }

    // Resumen para profesor
    public function report_summary($experiment_id)
    {
        $data = [];

        $data['experiment'] = Experiment::find($experiment_id);

        $res = GameExercise::join('game_instances', 'game_exercises.game_instance_id', '=', 'game_instances.id', 'left')
            ->where('game_instances.experiment_id', '=', $experiment_id)
            ->select(DB::raw('MIN(DISTINCT(DATE(time_start))) as start, MAX(DISTINCT(DATE(time_end))) as end'))
            ->get();

        $data['start_date'] = \Carbon\Carbon::parse($res[0]->start);
        $data['end_date'] = \Carbon\Carbon::parse($res[0]->end);

        $daysSpanish = [
            0 => 'lunes',
            1 => 'martes',
            2 => 'miércoles',
            3 => 'jueves',
            4 => 'viernes',
            5 => 'sábado',
            6 => 'domingo',
        ];

        $data['daysSpanish'] = $daysSpanish;

        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $playStudentPerDay = [];
        while (!$end_date->eq($start_date)) {
            $studentsPerDay = GameExercise::where(DB::raw('DATE(game_exercises.time_start)'), '=', $end_date->toDateString())
                ->where('game_instances.experiment_id', '=', $experiment_id)
                ->select(DB::raw("UNIX_TIMESTAMP(MAX(time_end)) - UNIX_TIMESTAMP(MIN(time_start)) as time,  user_id, users.name, users.first_surname, users.second_surname, users.course, users.course_letter, users.college"))
                ->join('users', 'game_exercises.user_id', '=', 'users.id', 'left')
                ->join('game_instances', 'game_instances.id', '=', 'game_exercises.game_instance_id', 'left')
                ->groupBy('user_id', DB::raw('DATE(game_exercises.time_start)'))
                ->get();


            $item = array(
                'date' => $end_date->copy(),
                'data' => $studentsPerDay
            );
            $playStudentPerDay[] = $item;

            $end_date->addDays(-1);
        }
        $data['data'] = $playStudentPerDay;

        //DB::enableQueryLog(); // Enable query log
        //echo  var_dump(DB::getQueryLog());
        $pdf = PDF::loadView('experiments.reports.summary', $data);
        return $pdf->stream('document.pdf');

        //return view('experiments.reports.summary', $data);//->with('experiment', $experiment);

    }

    // Resumen para profesor
    public function report_time($experiment_id)
    {

        $data = [];
        $data['experiment'] = Experiment::find($experiment_id);

        // Recupera fecha mas lejana y mas próxima de los que hay registro
        $res = GameExercise::join('game_instances', 'game_exercises.game_instance_id', '=', 'game_instances.id', 'left')
            ->where('game_instances.experiment_id', '=', $experiment_id)
            ->select(DB::raw('MIN(DISTINCT(DATE(time_start))) as start, MAX(DISTINCT(DATE(time_end))) as end'))
            ->get();

        $data['start_date'] = \Carbon\Carbon::parse($res[0]->start);
        $data['end_date'] = \Carbon\Carbon::parse($res[0]->end);

        $daysSpanish = [
            0 => 'lunes',
            1 => 'martes',
            2 => 'miércoles',
            3 => 'jueves',
            4 => 'viernes',
            5 => 'sábado',
            6 => 'domingo',
        ];

        $data['daysSpanish'] = $daysSpanish;

        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $playStudentPerDay = [];

        // Itera por las fechas desde la última hasta la mas reciente
        while (!$end_date->eq($start_date)) {
            $studentsPerDay = GameExercise::where(DB::raw('DATE(game_exercises.time_start)'), '=', $end_date->toDateString())
                ->where(function ($query) {
                    $query->where('event', '=', '1')
                        ->orWhere('event', '=', '3');
                })
                ->where('game_instances.experiment_id', '=', $experiment_id)
                ->select(DB::raw("game_exercises.event, game_exercises.time_start, user_id, users.name, users.first_surname, users.second_surname, users.course, users.course_letter, users.college"))
                ->join('users', 'game_exercises.user_id', '=', 'users.id', 'left')
                ->join('game_instances', 'game_instances.id', '=', 'game_exercises.game_instance_id', 'left')
                ->orderBy('user_id', 'ASC')
                ->orderBy('time_start', 'ASC')
                //->groupBy('user_id', DB::raw('DATE(game_exercises.time_start)'))
                ->get();

            // Agrupa ejercicios por usuario
            $studentsProcessed = [];
            if (count($studentsPerDay) > 0) {
                $data_item = [];

                // Inicializa último estudiante
                $lastStudent = $studentsPerDay[0];
                $data_item[$lastStudent->user_id] = [];
                $data_item[$lastStudent->user_id]['user'] = $lastStudent;
                $data_item[$lastStudent->user_id]['data'] = [];
                $data_item[$lastStudent->user_id]['time_total'] = \Carbon\Carbon::parse($lastStudent->time_start);

                // Inicializa último evento
                $lastEvent = $studentsPerDay[0];

                foreach ($studentsPerDay as $studentItem) {

                    // Si cambia de usuario, entonces reemplaza último usuario
                    if ($studentItem->user_id != $lastStudent->user_id) {
                        $lastStudent = $studentItem;
                        $data_item[$studentItem->user_id] = [];
                        $data_item[$studentItem->user_id]['user'] = $studentItem;
                        $data_item[$studentItem->user_id]['data'] = [];
                        $data_item[$studentItem->user_id]['time_total'] = \Carbon\Carbon::parse($studentItem->time_start);
                    }

                    // Agrega item de usuario
                    $temp_item = array(
                        'event' => $studentItem->event,
                        'time_record' => \Carbon\Carbon::parse($studentItem->time_start)
                    );

                    // Si el anterior es 1 (inicio), y actual es 3 (término)
                    if ($lastEvent->event == 1 && $studentItem->event == 3) {
                        $temp_item['diff'] = \Carbon\Carbon::parse($studentItem->time_start)->diffForHumans($lastEvent->time_start, true);
                    }

                    $data_item[$studentItem->user_id]['data'][] = $temp_item;

                    $lastEvent = $studentItem;  // Almacena último evento para próxima iteración
                }
            }


            $item = array(
                'date' => $end_date->copy(),
                'data' => $data_item
            );
            $playStudentPerDay[] = $item;

            $end_date->addDays(-1);
        }
        $data['data'] = $playStudentPerDay;

        //DB::enableQueryLog(); // Enable query log
        //echo  var_dump(DB::getQueryLog());


        $config = ['instanceConfigurator' => function ($mpdf) {
            $mpdf->autoPageBreak = true;
            //$mpdf->SetImportUse();
            //$mpdf->SetDocTemplate('/path/example.pdf', true);
        }];
        $pdf = PDF::loadView('experiments.reports.time_per_user', $data, [], $config);    //->save($pdfFilePath);


        //$pdf = PDF::loadView('experiments.reports.time_per_user', $data);
        return $pdf->stream('report_per_time.pdf');

        //return view('experiments.reports.summary', $data);//->with('experiment', $experiment);

    }


    // Resumen para profesor
    public function report_performance($experiment_id)
    {

        $data = [];
        $data['experiment'] = Experiment::find($experiment_id);

        // Recupera listado de usuario
        $users = User::select(DB::raw("user_id, users.name, users.first_surname, users.second_surname, users.course, users.course_letter, users.college"))
            ->join('user_experiments', 'user_experiments.user_id', '=', 'users.id', 'left')
            ->where('user_experiments.experiment_id', '=', $experiment_id)
            ->get();



        $studentsProcessed = [];
        $data['data'] = [];
        if (count($users) > 0) {
            foreach ($users as $studentItem) {

                // Si cambia de usuario, entonces reemplaza último usuario
                $lastStudent = $studentItem;
                $data_item = [];
                $data_item = [];
                $data_item['user'] = $studentItem;
                $data_item['data'] = [];
                $data_item['data'] = GameExercise::join('user_experiments', 'user_experiments.user_id', '=', 'game_exercises.user_id', 'left')
                    ->where('user_experiments.experiment_id', '=', $experiment_id)
                    ->where('game_exercises.user_id', $studentItem->user_id)
                    ->where('game_exercises.event', '=', '2')
                    ->select(DB::raw("exercise, user_response, response, IF(user_response = response, 'OK', 'BAD') as solved"))
                    ->orderBy('exercise', 'ASC')
                    ->orderBy('game_exercises.user_id', 'ASC')
                    ->orderBy('time_start', 'ASC')
                    ->get();

                $data['data'][] = $data_item;
            }
        }

        //DB::enableQueryLog(); // Enable query log
        //echo  var_dump(DB::getQueryLog());


        $config = ['instanceConfigurator' => function ($mpdf) {
            $mpdf->autoPageBreak = true;
            //$mpdf->SetImportUse();
            //$mpdf->SetDocTemplate('/path/example.pdf', true);
        }];
        $pdf = PDF::loadView('experiments.reports.performance_per_user', $data, [], $config);    //->save($pdfFilePath);

        return $pdf->stream('report_per_performance.pdf');

        //return view('experiments.reports.summary', $data);//->with('experiment', $experiment);

    }

    public function report_consolidated_performance($experiment_id) {
        
        $experiment = Experiment::find($experiment_id);

        if (empty($experiment)) {
            Flash::error('Experimento no encontrado');

            return redirect(route('experiments.index'));
        }

        return Excel::download(new ConsolidatedExperimentExport($experiment_id), 'consolidated_experiment.xlsx');

    }
    
    public function report_tests_results($experiment_id) {
        
        $experiment = Experiment::find($experiment_id);

        if (empty($experiment)) {
            Flash::error('Experimento no encontrado');

            return redirect(route('experiments.index'));
        }

        return Excel::download(new TestsResultsExport($experiment_id), 'tests_resume.xlsx');

    }
}
