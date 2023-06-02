<?php

namespace App\DataTables;

use App\Models\GameInstanceParameter;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class GameInstanceParameterDataTable extends DataTable
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

        return $dataTable
            ->addColumn('parametro_variable', function($model){
                return '3'; //$model->gameParameter->name;
            })
            ->addColumn('action', 'game_instance_parameters.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\GameInstanceParameter $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(GameInstanceParameter $model)
    {
        
        //return $model::rightjoin('game_parameters', function($join){
        //    $join->on('game_parameters.id', '=', 'game_instance_parameters.game_parameter_id')
        //        ->where('game_instance_id', $this->game_instance_id);
        //});

        
        return $model->where('game_instance_id', $this->game_instance_id)->newQuery();
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
                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
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
            
            'name' => ['title' => 'Valor'],
            
            'type' => ['title' => 'Tipo'],

            'variable' => ['title' => 'Nombre'],


        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'game_instance_parametersdatatable_' . time();
    }
}
