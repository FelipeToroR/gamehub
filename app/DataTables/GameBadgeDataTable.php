<?php

namespace App\DataTables;

use App\Models\GameBadge;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class GameBadgeDataTable extends DataTable
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
                ->addColumn('action', 'game_badges.datatables_actions')
                ->addColumn('badge_image', function ($gameBadge) { 
                    return '<img src="\\badges\\' . $gameBadge->id . '\\image" class="img-responsive img-thumbnail" />'; 
                })->rawColumns(['badge_image', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\GameBadge $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(GameBadge $model)
    {
        return $model->where('game_id', $this->game_id)->newQuery();
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
                  //  ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
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
            'badge_image',
            'code' => ['title' => 'Título'],
            'name' =>['title' => 'Nombre'],
            'description' => ['title' => 'Descripción', 'searchable' => true],
            'conditions' => ['title' => 'Condiciones', 'searchable' => true]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return '$MODEL_NAME_PLURAL_SNAKE_$datatable_' . time();
    }
}
