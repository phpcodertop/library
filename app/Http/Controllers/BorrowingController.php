<?php

namespace App\Http\Controllers;

use App\Book;
use App\Borrow;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class BorrowingController
 * @package App\Http\Controllers
 */
class BorrowingController extends Controller
{

    /**
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function borrow(Book $book) {
        $nextWeekDate = date("Y-m-d H:i:s", strtotime("+7 days"));
        Borrow::create([
            'book_id' => $book->id,
            'user_id' => auth()->id(),
            'delivery_date' => $nextWeekDate
        ]);

        $book->isBorrowed = 1;
        $book->save();


        return redirect()->back()->with('message','Book borrowed Successfully, you have to return it after a week.');
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function return(Book $book) {
        $borrowedBook = Borrow::where('book_id', $book->id)->firstOrFail();
        $book->isBorrowed = 0;
        $book->save();
        $borrowedBook->delete();
        return redirect()->back()->with('message','Book returned Successfully.');
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function extend(Book $book) {
        $borrowedBook = Borrow::where('book_id', $book->id)->firstOrFail();
        $oldDate = $borrowedBook->delivery_date;
        $newDate = Carbon::parse($oldDate)->add('7','day');
        $borrowedBook->delivery_date = $newDate;
        $borrowedBook->save();
        return redirect()->back()->with('message','Date extended Successfully.');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function borrowedBooks() {
        $books = Borrow::where('user_id', auth()->id())->with('book')->get();
        return view('borrowed-books', compact('books'));
    }

}
