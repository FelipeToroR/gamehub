<?php

namespace App\DataTables;

use App\Models\Experiment;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ExperimentDataTable extends DataTable
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
            ->addColumn('status', 'experiments.datatables_status_column')
            ->addColumn('operation_action', 'experiments.datatables_actions')
            ->addColumn('report_action', 'experiments.datatables_report_actions')
            ->rawColumns(['status', 'operation_action', 'report_action'])
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Experiment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Experiment $model)
    {
        $data = $model->newQuery();

        // Filtra por only_running
        if ($this->request()->get('only_running') == "1") {
            $data->where('status', '=', '1');
        }
        return $this->applyScopes($data);

        /*

        $mariages = Mariage::approved()->with('location')->select('mariages.*');
        if ($this->request()->get('year')) {
            $annee = Carbon::createFromFormat('Y', $this->request()->get('year'))->format('Y');
            $mariages->whereYear('date_ceremonie_souhaitee_debut', '=', $annee);
        }
        return $this->applyScopes($mariages);
         */


        //return $model->newQuery();
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
            //->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    [   'extend' => 'create', 
                        'text' =>'<i class="fa fa-plus"></i> Crear',
                        'className' => 'btn btn-default btn-sm no-corner',],
                    [   'extend' => 'print',
                        'text' =>'<i class="fa fa-print"></i> Imprimir',
                        'className' => 'btn btn-default btn-sm no-corner',],
                    [   'extend' => 'reset', 
                        'text' =>'<i class="glyphicon glyphicon-repeat"></i> Resetear',
                        'className' => 'btn btn-default btn-sm no-corner',],
                    [   'extend' => 'reload',
                        'text' =>'<i class="glyphicon glyphicon-refresh"></i> Recargar',
                        'className' => 'btn btn-default btn-sm no-corner',],
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
            'name' => ['title' => 'Nombre', 'sWidth'=>'10%'],
            'description' => ['title' => 'Descripción', 'searchable' => false, 'sWidth'=>'70%'],
            'status' => ['title' => 'Estado', 'searchable' => false, 'sWidth'=>'5%'],
            'operation_action' => [ 'title' => 'Operaciones', 'searchable' => false,  'sWidth'=>'15%',  'printable' => false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'experimentsdatatable_' . time();
    }
}
