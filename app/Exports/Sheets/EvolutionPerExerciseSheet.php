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


class EvolutionPerExerciseSheet implements FromQuery, WithTitle, WithHeadingRow, WithHeadings, WithMapping

{
    private $experiment;

    public function __construct($experiment)
    {
        $this->experiment = $experiment;
    }

    public function map($q): array
    {
        $ini = null;
        $end = null;
        $seq = explode('|', $q->secuencia);
        $seq_count = count($seq);
        $b = 0;
        $m = 0;
        $o = 0;
        foreach ($seq as $s) {
            if ($s == 'B')
                $b++;
            else if ($s == 'M')
                $m++;
            else
                $o++;
        }
        $porc_b =  number_format(($b / $seq_count), 2, ',', ' ');
        if ($seq_count > 0) {
            $ini = $seq[0];
            $end = $seq[$seq_count - 1];
        }

        // Inserta fila
        return [
            $q->usuario_id,     // Identificador de usuario 
            $q->nombre,         // Nombre de usuario
            $q->tipo,           // Nombre de instancia de experimento
            $q->ejercicio,      // Ejercicio
            $porc_b,            // Porcentaje de buenas
            $seq_count,         // Frecuencia del ejercicio para el usuario
            strval($b),         // Cantidad de respuestas buenas
            strval($m),         // Cantidad de respuestas malas
            strval($o),         // Cantidad de respuestas omitidas (en este caso son las que tienen respuesta 0 y distinto a respuesta correcta)
            $ini,               // Primer valor de secuencia de ejercicios
            $end,               // Último valor de secuencia de ejercicios
            $q->secuencia       // Secuencia de ejercicios, separadas por barra
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
            'ID Usuario',
            'Usuario',
            'Tipo',
            'Ejercicio',
            'PorcBuenas',
            'Frec.',
            'Buenas',
            'Malas',
            'Omit.',
            'Inicio',
            'Término',
            'Evol.'
        ];
    }


    public function headingRow(): int
    {
        return 1;
    }

    public function query()
    {
        $list = GameExercise::query()
            ->join('user_experiments', 'user_experiments.user_id', '=', 'game_exercises.user_id')
            ->join('game_instances', 'game_instances.id', '=', 'user_experiments.game_instance_id')
            ->join('users', 'users.id', '=', 'game_exercises.user_id')
            ->whereNotNull('user_experiments.game_instance_id')
            ->where('user_experiments.experiment_id', $this->experiment->id)
            ->where('game_exercises.event', 2)
            ->groupBy(DB::raw('users.id ASC, game_exercises.exercise ASC'))
            ->select(DB::raw(' DISTINCT(users.id) AS usuario_id, users.name AS nombre, game_instances.name AS tipo, game_exercises.exercise AS ejercicio, GROUP_CONCAT(IF(user_response <> response AND user_response = 0, \'O\', IF(user_response = response, \'B\', \'M\')) SEPARATOR \'|\') AS secuencia'));

        foreach ($list as &$item) {
            $item->put('pepe', '23');
        }

        return $list;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Evolución';
    }
}
