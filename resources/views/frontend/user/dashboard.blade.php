@extends('backend.layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Adds Management
                    </h4>
                </div><!--col-->

                <div class="col-md-7">
                    <p>Pause Adds: <button type="button" class="btn btn-primary" id="frm-example" data-dismiss="modal">Pause Adds</button></p>

                    <p>Enable Adds: <button type="button" class="btn btn-primary" id="enable-adds" data-dismiss="modal">Enable Adds</button></p>

                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table" id="myTable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Campain Id</th>
                                <th>Campain Name</th>
                                <th>Label</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $add)
                                <tr>
                                    <td>{{$add['id']}}}}</td>
                                    <td>{{ $add['id']}}</td>
                                    <td>{{ $add['name']}}</td>
                                    <td>{{ isset($add['label'][0]) ? $add['label'][0]['label'] : 'N/A'}}</td>
                                    <td>{{$add['actual_status']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->
            <div class="row">
                <div class="col-7">

                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">

                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->

    @push('after-scripts')
        <script>
            var oTable= '';
        $(document).ready( function () {

         oTable = $('#myTable').DataTable({
            columnDefs: [         // see https://datatables.net/reference/option/columns.searchable
                {
                    searchable    : false,
                    targets       : [0,1,2 , 4]
                },
                {
                    'checkboxes': {
                        'selectRow': true
                    },
                    targets       : 0
                },
            ],
            'select': {
                'style': 'multi'
            },
        });
        } );
        $('#enable-adds').on('click', function(e) {
            var form = this;

            var rows_selected = oTable.column(0).checkboxes.selected();


            // Iterate over all selected checkboxes
            var rowsId = [];
            $.each(rows_selected, function (index, rowId) {
                // Create a hidden element
                rowsId.push(rowId);
                console.log(index, 'index', rowId, 'rowId')
            });
            if (rowsId === undefined || rowsId.length == 0) {
                alert('kindly select rows')
            }
            let routeurl = "{{route('change.campain.userpause')}}";
            $.ajax({
                method: 'POST',
                url: routeurl,
                data: { "_token": "{{ csrf_token() }}",id: rowsId }
            })
                .done(function (data){
                    location.reload()
                    console.log(data)
                })
        });
            $('#frm-example').on('click', function(e) {
                var form = this;

                var rows_selected = oTable.column(0).checkboxes.selected();


                // Iterate over all selected checkboxes
                var rowsId = [];
                $.each(rows_selected, function (index, rowId) {
                    // Create a hidden element
                    rowsId.push(rowId);
                    console.log(index, 'index', rowId, 'rowId')
                });
                if (rowsId === undefined || rowsId.length == 0) {
                    alert('kindly select rows')
                }
                let routeurl = "{{route('change.campain.userenab')}}";
                $.ajax({
                    method: 'POST',
                    url: routeurl,
                    data: { "_token": "{{ csrf_token() }}",id: rowsId }
                })
                    .done(function (data){
                        location.reload()
                        console.log(data)
                    })
            });
        </script>
    @endpush

@endsection
