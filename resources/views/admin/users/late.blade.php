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
                <div class="card-header">Late Borrowers <a href="/send-email/all" class="btn btn-info float-right">Send a remainder Email to all late borrowers</a></div>
                <div class="card-body">
                    <table style="width: 100%" id="books-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <td>Book</td>
                                <td>Expected Delivery Date</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Send A remainder Email</td>
                            </tr>
                            @forelse($books as $book)
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->book->name }}</td>
                                <td>{{ Carbon\Carbon::parse($book->delivery_date)->format('d-m-Y') }}</td>
                                <td>{{ $book->user->name }}</td>
                                <td>{{ $book->user->email }}</td>
                                <td><a class="btn btn-success" href="{{ url('/send-email/'.$book->user->id) }}">Send A remainder Email</a></td>
                            @empty
                                <td colspan="6" class="text-center">No data.</td>
                            @endforelse
                        </thead>
                    </table>
                    {{ $books->links() }}
                </div>
            </div>
        </div>



    </div>
    <!-- /.row -->

@endsection

@section('scripts')
    <script>
        $(function() {
        });
    </script>
@endsection
