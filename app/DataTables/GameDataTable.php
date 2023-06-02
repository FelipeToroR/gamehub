<?php

namespace App\DataTables;

use Button;
use App\Models\Game;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class GameDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'games.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Game $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Game $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    [
                        'extend' => 'create', 
                        'className' => 'btn btn-sm btn-primary', 
                        'text' =>'<i class="fa fa-plus"></i> Crear'
                    ],
                    [
                        'extend' => 'export', 
                        'text' =>'<i class="fa fa-download"></i> Exportar',
                        'className' => 'btn btn-default btn-sm no-corner'
                    ],
                    [
                        'extend' => 'print', 
                        'text' =>'<i class="fa fa-print"></i> Imprimir',
                        'className' => 'btn btn-default btn-sm no-corner'
                    ],
                    [
                        'extend' => 'reset', 
                        'text' =>'<i class="fa fa-refresh"></i> Recargar',
                        'className' => 'btn btn-default btn-sm no-corner'
                    ],
                   
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name' => ['title' => 'Nombre'],
            'description' => ['title' => 'Descripción', 'searchable' => false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'gamesdatatable_' . time();
    }
}
