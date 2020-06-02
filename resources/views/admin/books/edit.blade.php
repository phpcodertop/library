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
                <div class="card-header">Edit Book</div>
                <div class="card-body">
                    <form action="{{ url('/books/'.$book->id.'/edit') }}" method="post" enctype="multipart/form-data" name="addBook">
                        @csrf
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text"  name="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Book Name" value="{{ $book->name }}" />
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Author</label>
                            <input type="text"  name="author" class="form-control" id="author" aria-describedby="emailHelp" placeholder="Enter Book Author" value="{{ $book->author }}" />
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">ISBN</label>
                            <input type="text"  name="isbn" class="form-control" id="isbn" aria-describedby="emailHelp" placeholder="Enter Book ISBN" value="{{ $book->isbn }}" />
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Publication Year</label>
                            <input type="text"  name="year" class="form-control" id="year" aria-describedby="emailHelp" placeholder="Enter Book Publication Year" value="{{ $book->year }}" />
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Book Image</label>
                            <img src="{{ asset('images/'.$book->image) }}" class="float-right" width="100" height="100">
                            <input type="file"   name="image" class="form-control" id="image" aria-describedby="emailHelp"  />
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ $book->description }}</textarea>
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-group">
                                <p class="text-center">
                                    <button type="submit" class="btn btn-success">Edit Book</button></p>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>



    </div>
    <!-- /.row -->
    <style>
        form .error {
            color: #ff0000;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <script>
        $(function() {
            $("form[name='addBook']").validate({
                rules: {
                    name: "required",
                    author: "required",
                    isbn: "required",
                    year: "required",
                    description: "required",
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
