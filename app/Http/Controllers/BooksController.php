<?php

namespace App\Http\Controllers;

use App\Book;
use App\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables as DataTable;

/**
 * Class BooksController
 * @package App\Http\Controllers
 */
class BooksController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin.books.index');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable() {
        $books = Book::latest();
        return DataTable::of($books)
            ->addColumn('edit', function ($book) {
                return '<a href="'.url('/books/'.$book->id.'/edit').'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->addColumn('delete', function ($book) {
                return '<a href="'.url('/books/'.$book->id.'/delete').'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-edit"></i> delete</a>';
            })
            ->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add() {
        return view('admin.books.add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdd(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required',
            'author' => 'required',
            'isbn' => 'required',
            'year' => 'required',
            'description' => 'required',
        ]);

        // get user inputs
        $name = $request->input('name');
        $author = $request->input('author');
        $isbn = $request->input('isbn');
        $year = $request->input('year');
        $description = $request->input('description');

        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);

        Book::create([
            'name' => $name,
            'author' => $author,
            'isbn' => $isbn,
            'year' => $year,
            'description' => $description,
            'image' => $imageName,
            'isBorrowed' => 0
        ]);

        return redirect()->to('/manage-books')->with(['message','Book added successfully.']);
    }

    /**
     * @param Book $book
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Book $book, Request $request) {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * @param Book $book
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(Book $book, Request $request) {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required',
            'author' => 'required',
            'isbn' => 'required',
            'year' => 'required',
            'description' => 'required',
        ]);

        // update book
        $book->name = $request->input('name');
        $book->author = $request->input('author');
        $book->isbn = $request->input('isbn');
        $book->year = $request->input('year');
        $book->description = $request->input('description');

        if ($request->hasFile('image')) {
            @unlink(public_path('images').'/'.$book->image);
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $imageName);
            $book->image = $imageName;
        }

        $book->save();
        return redirect()->back()->with('message','Book Saved Successfully.');
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Book $book) {
        @unlink(public_path('images').'/'.$book->image);
        $borrowedBook = Borrow::where('book_id', $book->id)->first();
        if ($borrowedBook) { $borrowedBook->delete(); }
        $book->delete();
        return redirect()->to('/manage-books')->with('message','Book Deleted Successfully.');
    }

}
