<?php

namespace App\Exports;

use App\Models\Experiment;
use App\Exports\Sheets\EvolutionPerExerciseSheet;
use App\Exports\Sheets\EventPerTimeSheet;
use App\Exports\Sheets\ConsolidatedPerUserSheet;
use App\Exports\Sheets\TestPerUserSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ConsolidatedExperimentExport implements WithMultipleSheets
{

    public $experiment;

    public function __construct($experiment_id)
    {
        $this->experiment = Experiment::find($experiment_id);
    }


    public function drawings()
    {
        return new Drawing();
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new EvolutionPerExerciseSheet($this->experiment);
        $sheets[] = new ConsolidatedPerUserSheet($this->experiment);
        $sheets[] = new EventPerTimeSheet($this->experiment);
        //$sheets[] = new TestPerUserSheet($this->experiment);

        return $sheets;
    }

    public function sheet_summary()
    {
        return Experiment::all();
    }
}
