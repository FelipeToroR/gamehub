<?php

namespace App\Exports\Sheets;

use DB;
use App\User;
use App\Models\GameExercise;
use App\Models\UserExperiment;
use App\Models\SurveyResponse;
use App\Models\Survey;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class TestPerUserSheet implements FromQuery, WithTitle, WithHeadingRow, WithHeadings, WithMapping, ShouldQueue

{
    use Exportable;
    private $survey;

    public function __construct($survey)
    {
        $this->survey = $survey;
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
            $row->label,
            $row->question,
            $row->response
        ];
    }


    public function headings(): array
    {

        $heads = [
            'ID',
            'Nombre',
            'Etiqueta',
            'Pregunta',
            'Respuesta'
        ];
        return $heads;
    }


    public function headingRow(): int
    {
        return 1;
    }

    public function query()
    {      
        return (User::join('survey_responses', 'users.id', '=', 'survey_responses.user_id')
        ->where('survey_responses.survey_id', '=', $this->survey->id)
        ->where('label', '!=', 'end')
        ->select(DB::raw('"user_id" as user_id, users.name as user_name, label as label, question as question, response as response')));
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->survey->name;
    }
}
