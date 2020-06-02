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
                <div class="card-header">Manage Books <a class="btn btn-success float-right" href="{{ url('books/add') }}">Add New Book</a></div>
                <div class="card-body">
                    <table style="width: 100%" id="books-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <td>Name</td>
                                <td>Author</td>
                                <td>ISBN</td>
                                <td>Edit</td>
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
                ajax: '{{ url('/books-data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'author', name: 'author' },
                    { data: 'isbn', name: 'isbn' },
                    { data: 'edit', name: 'edit', orderable: false, searchable: false },
                    { data: 'delete', name: 'delete', orderable: false, searchable: false }
                ],
                "aoColumnDefs": [ {
                    "aTargets": [ 4,5 ],
                    "mRender": function ( data, type, full ) {
                        return $("<div/>").html(data).text();
                    }
                } ],

                "order": [[ 0, "desc" ]]
            });
        });
    </script>
@endsection
