@section('css')
    @include('layouts.datatables_css')
@endsection
<div>
    <label for="only_running">Mostrar solo en ejecución</label>
    <input type="checkbox" id="only_running" name="only_running" checked value="1"/>
</div>
{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}

@push('scripts')
    @include('layouts.datatables_js')
    <!-- {--!! $dataTable->scripts() !!--} -->
    <script>
    (function(window, $) {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "{{Request::url()}}",
                "type": "GET",
                "data": function(data) {
                    data.only_running = ($('#only_running:checked').val() == '1') ? 1 : 0;
                    console.log('run=' + data.only_running)
                    for (var i = 0, len = data.columns.length; i < len; i++) {
                        if (!data.columns[i].search.value) delete data.columns[i].search;
                        if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                        if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                        if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                    }
                    delete data.search.regex; 
                }
            },
            "columns": [{
                "name": "name",
                "data": "name",
                "title": "Nombre",
                "sWidth": "10%",
                "orderable": true,
                "searchable": true
            }, {
                "name": "description",
                "data": "description",
                "title": "Descripci\u00f3n",
                "searchable": false,
                "sWidth": "70%",
                "orderable": true
            }, {
                "name": "status",
                "data": "status",
                "title": "Estado",
                "searchable": false,
                "sWidth": "5%",
                "orderable": true
            }, {
                "name": "operation_action",
                "data": "operation_action",
                "title": "Operaciones",
                "searchable": false,
                "sWidth": "15%",
                "orderable": true
            }],
            "responsive": true,
            "autoWidth": false,
            "dom": "Bfrtip",
            "stateSave": true,
            "order": [
                [0, "desc"]
            ],
            "buttons": [{
                "extend": "create",
                "text": "<i class=\"fa fa-plus\"><\/i> Crear",
                "className": "btn btn-default btn-sm no-corner"
            }, {
                "extend": "print",
                "text": "<i class=\"fa fa-print\"><\/i> Imprimir",
                "className": "btn btn-default btn-sm no-corner"
            }, {
                "extend": "reset",
                "text": "<i class=\"glyphicon glyphicon-repeat\"><\/i> Resetear",
                "className": "btn btn-default btn-sm no-corner"
            }, {
                "extend": "reload",
                "text": "<i class=\"glyphicon glyphicon-refresh\"><\/i> Recargar",
                "className": "btn btn-default btn-sm no-corner"
            }]
        });

        $('#only_running').on('change', function(e) {
            console.log("chck");
            window.LaravelDataTables["dataTableBuilder"].draw();
            e.preventDefault();
        });

    })(window, jQuery);


       
    </script>
@endpush