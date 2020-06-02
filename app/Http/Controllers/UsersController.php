<?php

namespace App\Http\Controllers;

use App\Borrow;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Datatables as DataTable;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin.users.index');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable() {
        $admins = User::where('approved', 0);
        return DataTable::of($admins)
            ->addColumn('edit', function ($book) {
                return '<a href="'.url('/approve-admins/'.$book->id.'/approve').'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Approve</a>';
            })
            ->addColumn('delete', function ($book) {
                return '<a href="'.url('/approve-admins/'.$book->id.'/delete').'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-edit"></i> delete</a>';
            })
            ->make(true);
    }

    /**
     * @param User $admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(User $admin) {
        $admin->approved = 1;
        $admin->save();
        return redirect()->to('/approve-admins')->with('message','User approved Successfully.');
    }

    /**
     * @param User $admin
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(User $admin) {
        $admin->delete();
        return redirect()->to('/approve-admins')->with('message','Deleted Successfully.');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lateBorrowers() {
        $books = Borrow::whereDate('delivery_date', '<', Carbon::now())->with(['user','book'])->paginate(10);
        return view('admin.users.late', compact('books'));
    }

    /**
     * @param $idOrAll
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmail($idOrAll) {
        if ($idOrAll != 'all') {
            $user = User::findOrFail($idOrAll);
            $email = $user->email;
            $username = $user->name;
            Mail::send('email', ['username' => $username, 'email' => $email], function ($message) use ($email)
            {
                $message->from('mohammedanwar@gmail.com', 'Mohamed Anwar');
                $message->subject('You are late in returning the book you have borrowed');
                $message->to($email);
            });
            return redirect()->back()->with('message','Email Sent Successfully.');
        }
        $books = Borrow::whereDate('delivery_date', '<', Carbon::now())->with(['user','book'])->get();
        foreach ($books as $book) {
            $email = $book->user->email;
            $username = $book->user->name;
            Mail::send('email', ['username' => $username, 'email' => $email], function ($message) use ($email)
            {
                $message->from('mohammedanwar@gmail.com', 'Mohamed Anwar');
                $message->subject('You are late in returning the book you have borrowed');
                $message->to($email);
            });
        }
        return redirect()->back()->with('message','Email Sent Successfully.');
    }


}
