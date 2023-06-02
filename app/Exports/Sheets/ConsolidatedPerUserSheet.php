<?php

namespace App\Exports\Sheets;

use DB;
use App\Models\GameExercise;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;



class ConsolidatedPerUserSheet implements FromQuery, WithTitle, WithHeadingRow, WithHeadings, WithMapping, WithStrictNullComparison

{
    private $experiment;

    public function __construct($experiment)
    {
        $this->experiment = $experiment;
    }

    public function map($q): array
    {
        $seq = explode('|', $q->seq);
        $seq_count = count($seq);
        // Inserta fila
        return [ 
            $q->nombre,                            // Nombre
            $q->tipo,                                               // Tipo
            '-',                                                    // Género
            '-',                                                    // Performance
            '-',                                                    // CantJuegos
            $q->qexer,                                    // CantEjer
            $q->cant_ejercicios_buenos,                             // CantEjer.Buenos
            $q->cant_ejercicios_malos,                              // CantEjer.Malos
            $q->cant_ejercicios_omitidos,                           // CantEjer.Omit
            ($q->qexer > 0) ? $q->cant_ejercicios_buenos / $q->qexer : "0",       // DUDA es por los distintos(?)
            ($q->qexer > 0) ? $q->cant_ejercicios_malos / $q->qexer : "0",
            ($q->qexer > 0) ? $q->cant_ejercicios_omitidos / $q->qexer : "0",
            '-',                                                    // EjerXJuego
            '-',                                                    // TmpoPromResp.Buenas
            '-',                                                    // TotalPtje
            '-',
            '-',
            '-',
            $q->qdistinctexer,  // EjerDist
            $q->tb11sumbb,    // EjerBB
            $q->tb11sumbm,            // EjerBM
            $q->tb11summb,    // EjerMB
            $q->tb11summm,    // EjerMM
            $q->qenhacement,    // CantMejora
            '-',
            '-',
            '-',    //  
            ($q->qdistinctexer > 0) ? ($q->tb11sumbb / $q->qdistinctexer)*100 : "0",    //PorcEjerBB
            ($q->qdistinctexer > 0) ? ($q->tb11sumbm / $q->qdistinctexer)*100 : "0",    //PorcEjerBM
            ($q->qdistinctexer > 0) ? ($q->tb11summb / $q->qdistinctexer)*100 : "0",    //PorcEjerMB
            ($q->qdistinctexer > 0) ? ($q->tb11summm / $q->qdistinctexer)*100 : "0",    //PorcEjerMM
            ($q->qdistinctexer > 0) ? ($q->qenhacement / $q->qdistinctexer)*100 : "0",                                                // PorcEjerMejora
            $q->seq                                                 // DEBUG
        ];



        
    }

    public function columnFormats(): array
    {
        return [
            NumberFormat::FORMAT_PERCENTAGE
        ];
    }



    public function headings(): array
    {
  

        return [
            'Nombre',
            'Tipo',
            'Género',
            'Performance',
            'CantJuegos',
            'CantEjer',
            'CantEjer.Buenos',
            'CantEjer.Malos',
            'CantEjer.Omit',
            'PorcEjer.Buenos',
            'PorcEjer.Malos',
            'PorcEjer.Omit',
            'EjerXJuego',
            'TmpoPromResp.Buenas',
            'TotalPtje',
            'PtjePromJuego',
            'TmpoTotResp',
            'TmpoTotRespBuena',
            'EjerDist',
            'EjerBB',
            'EjerBM',
            'EjerMB',
            'EjerMM',
            'CantMejora',
            'PorcEjerDist',
            'PorcIniB',
            'PorcFinB',
            'PorcEjerBB',
            'PorcEjerBM',
            'PorcEjerMB',
            'PorcEjerMM',
            'PorcEjerMejora',
            'debug'
        ];
    }


    public function headingRow(): int
    {
        return 1;
    }

    public function query()
    {
        $list = GameExercise::from('game_exercises as ge00')
            ->join('user_experiments as ue00', DB::raw('ue00.user_id'), '=', DB::raw('ge00.user_id'))
            ->join('game_instances as gi00', DB::raw('gi00.id'), '=', DB::raw('ue00.game_instance_id'))
            ->join('users as u00', DB::raw('u00.id'), '=', DB::raw('ge00.user_id'))
            ->join(DB::raw(
"
(
    SELECT tb10.u10id AS u11id, tb10.u10name AS u11name, SUM(tb10bb) AS tb11sumbb, SUM(tb10mm) AS tb11summm, SUM(tb10mb) AS tb11summb, SUM(tb10bm) AS tb11sumbm
	FROM (
		SELECT 
		 u10.id AS u10id, u10.name AS u10name, gi10.name AS gi10name, ge10.exercise AS ge10exercise,
		 (GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 'O', IF(ge10.user_response = ge10.response, 'B', 'M')))) AS tb10seq,
		 LEFT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 0, IF(ge10.user_response = ge10.response, 1, 0))),1) = 1 AND  
		 RIGHT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 0, IF(ge10.user_response = ge10.response, 1, 0))),1) = 1 
		 AS tb10bb,
		 LEFT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 1, IF(ge10.user_response = ge10.response, 0, 1))),1) = 1 AND  
		 RIGHT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 1, IF(ge10.user_response = ge10.response, 0, 1))),1) = 1 
		 AS tb10mm,
		 LEFT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 0, IF(ge10.user_response = ge10.response, 1, 0))),1) = 1 AND  
		 RIGHT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 1, IF(ge10.user_response = ge10.response, 0, 1))),1) = 1 
		 AS tb10bm,
		 LEFT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 1, IF(ge10.user_response = ge10.response, 0, 1))),1) = 1 AND  
		 RIGHT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 0, IF(ge10.user_response = ge10.response, 1, 0))),1) = 1 
		 AS tb10mb
		FROM game_exercises AS ge10 
		LEFT JOIN user_experiments AS ue10 ON ue10.user_id = ge10.user_id
		LEFT JOIN game_instances AS gi10 ON gi10.id = ue10.game_instance_id
		LEFT JOIN users AS u10 ON u10.id = ge10.user_id
		WHERE ue10.game_instance_id IS NOT NULL 
			AND ue10.experiment_id = " .  $this->experiment->id . "
			AND ge10.event = 2
		GROUP BY u10.id asc, ge10.exercise ASC
    ) tb10 GROUP BY tb10.u10id
    ) AS j01
"), DB::raw('j01.u11id') , '=', DB::raw('u00.id'))


            ->whereNotNull('ue00.game_instance_id')
            ->where('ue00.experiment_id', $this->experiment->id)
            ->where('ge00.event', 2)
            ->groupBy(DB::raw('u00.id'))
            ->orderBy(DB::raw('u00.id'), 'ASC')

            ->select(DB::raw("
            DISTINCT(u00.id) AS usuario_id,
            TRIM(CONCAT(u00.name, \" \", COALESCE(u00.first_surname, \"\"), \" \", COALESCE(u00.second_surname, \"\") )) AS nombre,
            gi00.name AS tipo,
            u00.gender AS gender,

            (SELECT COUNT(*) FROM game_exercises AS ge01 
                JOIN user_experiments AS ue01 ON ge01.game_instance_id = ue01.game_instance_id
                WHERE ge01.event = 1 AND ge01.user_id = u00.id AND ue01.experiment_id = " . $this->experiment->id . "	# PARAMETRO
            ) AS it00cnt_start_event,

            (SELECT COUNT(*) FROM game_exercises AS ge02
             JOIN user_experiments AS ue02 ON ge02.game_instance_id = ue02.game_instance_id
             WHERE ge02.event = 3 AND ge02.user_id = u00.id AND ue02.experiment_id = " .  $this->experiment->id . "	# PARAMETRO
            ) AS it00cnt_end_event, 

            (SELECT COUNT(*) FROM game_exercises AS ge03 
                JOIN user_experiments AS ue03 ON ge03.game_instance_id = ue03.game_instance_id AND ue03.user_id = ge03.user_id
                WHERE ge03.event = 2 AND ge03.user_id = u00.id AND ue03.experiment_id = " .  $this->experiment->id . ") 
             AS qexer,

            (SELECT COUNT(*) FROM game_exercises AS ge04  
                JOIN user_experiments AS ue04 ON ge04.game_instance_id = ue04.game_instance_id AND ue04.user_id = ge04.user_id
                WHERE ge04.event = 2 AND ge04.user_id = u00.id AND ( ge04.user_response = ge04.response ) AND ue04.experiment_id = " .  $this->experiment->id . ") 
            AS cant_ejercicios_buenos,

            (SELECT COUNT(*) FROM game_exercises AS ge05  
                JOIN user_experiments AS ue05 ON ge05.game_instance_id = ue05.game_instance_id AND ue05.user_id = ge05.user_id
                WHERE ge05.event = 2 AND ge05.user_id = u00.id AND ( ge05.user_response != ge05.response AND ge05.user_response != 0) AND ue05.experiment_id = " .  $this->experiment->id . ") 
            AS cant_ejercicios_malos,

            (SELECT COUNT(*) FROM game_exercises AS ge06
                JOIN user_experiments AS ue06 ON ge06.game_instance_id = ue06.game_instance_id AND ue06.user_id = ge06.user_id
                WHERE ge06.event = 2 AND ge06.user_id = u00.id AND ( ge06.user_response != ge06.response AND ge06.user_response = 0 ) AND  ue06.experiment_id = " .  $this->experiment->id . " ) 
            AS cant_ejercicios_omitidos,

           (SELECT COUNT(DISTINCT(ge07.exercise)) FROM game_exercises AS ge07
                JOIN user_experiments AS ue07 ON ge07.game_instance_id = ue07.game_instance_id AND ue07.user_id = ge07.user_id
                WHERE ge07.event = 2 AND ge07.user_id = u00.id AND ue07.experiment_id = " .  $this->experiment->id . ")
            AS qdistinctexer,

            tb11sumbb,
            tb11summm,
            tb11sumbm,
            tb11summb,
            (tb11summb - tb11sumbm) as qenhacement
            
      
           "));

        return $list;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Consolidado';
    }
}
