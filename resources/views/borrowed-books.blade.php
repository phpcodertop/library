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
    <div class="row my-4 mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Borrowed Books</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tr>
                            <td>Book Name</td>
                            <td>Return Date</td>
                            <td>Return</td>
                            <td>Extend by a week</td>
                        </tr>
                        @forelse($books as $book)
                            <td>{{ $book->book->name }}</td>
                            <td><span>{{ Carbon\Carbon::parse($book->delivery_date)->format('d-m-Y') }}</span></td>
                            <td><a class="btn btn-info" href="{{ url('/borrow/'.$book->book->id.'/return') }}">Return</a></td>
                            <td><a class="btn btn-success" href="{{ url('/borrow/'.$book->book->id.'/extend') }}">Extend</a></td>
                        @empty
                            <td colspan="4" class="text-center">You didn't borrowed any book yet.</td>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->

@endsection

