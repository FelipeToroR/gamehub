<?php

namespace App\Exports;

use App\Models\Experiment;
use App\Models\Survey;
use App\Exports\Sheets\TestPerUserSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class TestsResultsExport implements WithMultipleSheets
{

    public $surveys;

    public function __construct($experiment_id)
    {
        $this->surveys = Survey::where('experiment_id', $experiment_id)->get();
    }


    public function drawings()
    {
        return new Drawing();
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->surveys as $survey) {
            $sheets[] = new TestPerUserSheet($survey);
        }
        
        //$sheets[] = new TestPerUserSheet($this->experiment);

        return $sheets;
    }

    public function sheet_summary()
    {
        return Experiment::all();
    }
}
