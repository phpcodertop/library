<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login() {
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request) {
        // validate user inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // get user inputs
        $email = $request->input('email');
        $password = $request->input('password');

        // search for user on database based on email
        $user = User::where('email', $email)->first();

        // check if user exists and password match and account is approved
        if ($user && Hash::check($password, $user->password) && $user->approved == 1) {
            Auth::login($user);
            return redirect()->to('/');
        }

        return redirect()->back()->withErrors('You have entered an invalid credentials, or your account is not approved.');

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register() {
        return view('auth.register');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(Request $request) {
        // validate user inputs
        $request->validate([
           'name' => 'required',
           'email' => 'required|email|unique:users,email',
           'password' => 'required',
           'type' => 'required',
        ]);
        // get user inputs
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $type = $request->input('type');

        // prepare user data array
        $userData = [
          'name' => $name,
          'email' => $email,
          'password' => bcrypt($password)
        ];

        switch ($type) {
            case 'student':
                $userData['role'] = 'student';
                $userData['approved'] = 1;
                $user = User::create($userData);
                Auth::login($user);
                return redirect()->to('/');
                break;
            case 'admin':
                $userData['role'] = 'admin';
                $userData['approved'] = 0;
                $user = User::create($userData);
                return redirect()->to('/')->with('message','Your account is waiting for approval, we will send you an email after approval.');
                break;
        }


    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->to('/');

    }

}
