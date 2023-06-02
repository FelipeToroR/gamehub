<?php

namespace App\Exports\Sheets;

use App\Models\GameExercise;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExperimentPerGameSheet implements FromQuery, WithTitle, WithHeadingRow, WithHeadings

{
    private $month;
    private $year;
    private $game_instance;

    public function __construct($game_instance)
    {
        $this->game_instance = $game_instance;
    }

    
    public function headings(): array
    {
        return [
            'ID Evento',
            'Tipo de evento',
            'Ronda',
            'Ejercicio',
            'Respuesta de usuario',
            'Respuesta correcta',
            'Tiempo inicio',
            'Tiempo término',
            'Datos extra',
            'ID Instancia de juego',
            'ID Usuario'
        ];
    }


    public function headingRow(): int
    {
        return 1;
    }

    public function query()
    {
        return GameExercise::where('game_instance_id', $this->game_instance->id);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Grupo_' . $this->game_instance->name;
    }
}