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
        <div class="col-md-4">
            <img width="378" height="500" src="{{ asset('/images/'.$book->image) }}" alt="">
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-7">
            <h6>By: {{ $book->author }}</h6>
            <h1>{{ $book->name }}</h1>
            <h6>ISBN: {{ $book->isbn }}</h6>
            <h6>Release Year: {{ $book->year }}</h6>
            <p>{{ $book->description }}</p>
            @if(! $book->isBorrowed)
                <a href="{{ url('/borrow/'.$book->id) }}" class="btn btn-success">Borrow this book.</a>
                @else
                @if($borrow->user_id == auth()->id())
                    <a href="{{ url('/borrow/'.$book->id.'/extend') }}" class="btn btn-info">Extend delivery date by a week.</a>
                    <a href="{{ url('/borrow/'.$book->id.'/return') }}" class="btn btn-success">Return this book.</a>
                @endif
                <p class="alert alert-danger mt-2">This book will be available at {{ Carbon\Carbon::parse($borrow->delivery_date)->format('d-m-Y') }}</p>
            @endif
        </div>

    </div>
    <!-- /.row -->
@endsection

