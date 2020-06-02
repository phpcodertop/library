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

    <!-- Jumbotron Header -->
    <header class="jumbotron my-4">
        <h1 class="display-3">My Library</h1>
        <p class="lead">Welcome to My Library, This application is used for library management.</p>
    </header>

    <!-- Page Features -->
    <div class="row text-center">
        @foreach($books as $book)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="{{ url('/book/'.$book->id.'/show') }}">
                    <img class="card-img-top" style="width: 252px; height: 325px;" src="{{ asset('/images/'.$book->image) }}" alt="">
                    </a>
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{ url('/book/'.$book->id.'/show') }}">{{ $book->name }}</a></h4>
                        <p class="card-text">
                            {{ substr($book->description, 0,  100) }}...
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
            <div class="col-md-12 text-xs-center">
                {{ $books->links() }}
            </div>
    </div>
    <!-- /.row -->
@endsection

