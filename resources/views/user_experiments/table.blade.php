@section('css')
    @include('layouts.datatables_css')

    <style>
    tr.selected {
        background-color: #00800017 !important;
        font-weight: bold;
    }
    </style>
@endsection

{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}



@push('scripts')
    @include('layouts.datatables_js')
    <!-- SCRIPT - INIT -->
    <script>
      
            var selected = [];


    </script>
    {!! $dataTable->scripts() !!}
    <!-- SCRIPT - END -->


    <script>
    $(document).ready(function() {
        var table = window.LaravelDataTables["dataTableBuilder"];

     
        
        $('#dataTableBuilder tbody').on('click', 'tr', function () {
            var data = table.row( this ).data();
            //alert( 'You clicked on '+data['id']+'\'s row' );
            var self = this;


            //debugger;
            data['action'] = '<i class="fa fa-spinner fa-pulse"></i> Cargando ...';
            $('#dataTableBuilder').dataTable().fnUpdate(data,self,undefined,false);

            $.ajax({
                type: "POST",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/experiments/{{$experiment_id}}/users" ,
                data: data
            })
                .then(function(data_result){
                    if(data_result.result == 1){
                        data['action'] = '<div class="label label-success">INCLUIDO</div>';
                    }else{
                        data['action'] = '<div class="label label-danger">NO INCLUIDO</div>';
                    }
                    $('#dataTableBuilder').dataTable().fnUpdate(data,self,undefined,false);
                   
                });
        } );
    });

    </script>
@endpush