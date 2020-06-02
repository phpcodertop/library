@extends('layout.main')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-success" role="alert">
            <div class="alert-text">{{ Session::get('message') }}</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>
            </div>
        </div>
    @endif


    <!-- Page Features -->
    <div class="row p-5">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Approve Admins</div>
                <div class="card-body">
                    <table style="width: 100%" id="books-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Approve</td>
                                <td>Delete</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>



    </div>
    <!-- /.row -->

@endsection

@section('scripts')
    <script>
        $(function() {
            $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('/admins-data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'edit', name: 'edit', orderable: false, searchable: false },
                    { data: 'delete', name: 'delete', orderable: false, searchable: false }
                ],
                "aoColumnDefs": [ {
                    "aTargets": [ 3,4 ],
                    "mRender": function ( data, type, full ) {
                        return $("<div/>").html(data).text();
                    }
                } ],

                "order": [[ 0, "desc" ]]
            });
        });
    </script>
@endsection
