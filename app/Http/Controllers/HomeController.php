<?php

namespace App\Http\Controllers;

use App\Book;
use App\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $books = Book::latest()->paginate(16);
        return view('home', compact('books'));
    }

    /**
     * @param Book $book
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Book $book) {
        $borrow = Borrow::where('book_id',$book->id)->first();
        return view('book-details', compact('book', 'borrow'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account() {
        $user = Auth::user();
        return view('account', compact('user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAccount(Request $request) {
        // validate user input
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // check if password exists
        $password = $request->input('password');
        if ($password && $password != null && $password != '') {
            $user->password = bcrypt($password);
        }
        $user->save();
        return redirect()->back()->with('message','Saved Successfully.');
    }

}
