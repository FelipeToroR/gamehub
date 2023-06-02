<?php

namespace App\DataTables;
use DB;
use App\Models\UserExperiment;
use App\User;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UserExperimentDataTable extends DataTable
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
            /* ->addColumn('action', function(UserExperiment $user) {
                    
                    return '' . $user->experiment_id . '';
            });*/
            ->addColumn('action', 'user_experiments.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\UserExperiment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UserExperiment $model)
    {
        return UserExperiment::rightjoin('users', function($join){
            $join->on('users.id', '=', 'user_experiments.user_id')
                ->where('user_experiments.experiment_id', '=', $this->experiment_id);
        });
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
            ->parameters([
                'order' => [
                    0,
                    'asc'
                ]
           ])
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
            //'intro' => ['searchable' => false],
            'name' => ['searchable' => false],
            'first_surname' => ['searchable' => false],
            'course' => ['searchable' => false],
            'course_letter' => ['searchable' => false],
            'email' => ['searchable' => false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'user_experimentsdatatable_' . time();
    }
}
