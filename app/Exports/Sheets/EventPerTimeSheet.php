<?php

namespace App\Exports\Sheets;

use DB;
use App\Models\GameExercise;
use App\Models\UserExperiment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class EventPerTimeSheet implements FromQuery, WithTitle, WithHeadingRow, WithHeadings, WithMapping

{
    private $experiment;

    public function __construct($experiment)
    {
        $this->experiment = $experiment;
    }

    public function columnFormats(): array
    {
        return [
            NumberFormat::FORMAT_PERCENTAGE
        ];
    }

    public function map($row): array
    {
        // Inserta fila
        return [
            $row->user_id,
            $row->user_name,
            $row->user_surname,
            $row->user_course,
            $row->user_course_letter,
            $row->college,
            $row->event,
            strval($row->round),
            $row->exercise,
            $row->user_response,
            $row->response,
            $row->response_eval,
            $row->time_start,
            $row->time_end,
            $row->time_dif,
            $row->extra,
            $row->game_inst_id,
            $row->game_inst_name
        ];
    }


    public function headings(): array
    {
        return [
            'UsuarioID',
            'Nombre',
            'Apellido',
            'Curso',
            'CursoLetra',
            'Colegio',
            'Evento',
            'Ronda',
            'Ejercicio',
            'RespuestaUsuario',
            'Respuesta',
            'RespuestaEval',
            'TiempoInicio',
            'TiempoTermino',
            'TiempoDif',
            'Extra',
            'InstJuegoID',
            'InstJuegoNombre'
        ];
    }


    public function headingRow(): int
    {
        return 1;
    }

    public function query()
    {
        $list = UserExperiment::query()
            ->join('game_exercises', 'user_experiments.user_id', '=', 'game_exercises.user_id', 'left')
            ->join('game_instances', 'user_experiments.game_instance_id', '=', 'game_instances.id', 'left')
            ->join('users', 'user_experiments.user_id', '=', 'users.id', 'left')
            ->where('user_experiments.experiment_id', $this->experiment->id)
            ->whereNotNull('user_experiments.game_instance_id')
            ->orderBy('user_experiments.id', 'ASC')
            ->orderBy('game_exercises.user_id', 'ASC')
            ->orderBy('game_exercises.time_start', 'ASC')
            ->select(DB::raw('users.id as user_id,
                users.name as user_name,
                users.first_surname as user_surname,
                users.course as user_course,
                users.course_letter as user_course_letter,
                users.college,
                event,
                round,
                exercise,
                user_response,
                response,
                IF(user_response <> response AND user_response = 0, \'O\', IF(user_response = response AND EVENT = 2, \'B\', IF(EVENT <> 2, NULL, \'M\'))) AS response_eval,
                time_start, time_end, TIMEDIFF(time_end, time_start) AS time_dif,
                extra, game_exercises.game_instance_id as game_inst_id, game_instances.name as game_inst_name'));

        return $list;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Bruto';
    }
}
