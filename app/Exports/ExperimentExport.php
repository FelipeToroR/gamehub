<?php

namespace App\Exports;

use App\Models\Experiment;
use App\Exports\Sheets\ExperimentPerGameSheet;



use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ExperimentExport implements WithMultipleSheets
{

    public $experiment;

    public function __construct($experiment_id)
    {
        $this->experiment = Experiment::find($experiment_id);
    }


    public function drawings()
    {
        //$drawing = new Drawing();
        //$drawing->setName('GameHUB');
        //$drawing->setDescription('Reporte de experimento');
        //$drawing->setHeight(90);
        //$drawing->setCoordinates('B3');
        return new Drawing();
    }

    public function sheets(): array
    {
        $sheets = [];

        $game_instances = $this->experiment->gameInstances;
        if ($game_instances->count() > 0) {
            foreach ($game_instances as $game_instance) {
                $sheets[substr($game_instance->name, 0, 30)] = new ExperimentPerGameSheet($game_instance);
            }
        }else{
            $sheets['NINGUNO'] = "hola";
        }

        //for ($month = 1; $month <= 12; $month++) {
        //    $sheets[] = Experiment::all();
        //}

        //$sheets['hola'] = $this->sheet_summary();
        //$sheets['chao'] = Experiment::all();

        return $sheets;
    }

    public function sheet_summary()
    {
        return Experiment::all();
    }
}
