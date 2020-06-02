<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// home page route
Route::get('/', 'HomeController@index');
// auth routes
Route::get('/login', 'AuthController@login')->middleware('guest')->name('login');
Route::post('/login', 'AuthController@postLogin')->middleware('guest');
Route::get('/register', 'AuthController@register')->middleware('guest');
Route::post('/register', 'AuthController@postRegister');


Route::get('/book/{book}/show', 'HomeController@show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', 'AuthController@logout');
    Route::get('/account', 'HomeController@account');
    Route::post('/account', 'HomeController@postAccount');
    Route::get('/my-borrowed-books', 'BorrowingController@borrowedBooks');
    Route::get('/borrow/{book}', 'BorrowingController@borrow');
    Route::get('/borrow/{book}/return', 'BorrowingController@return');
    Route::get('/borrow/{book}/extend', 'BorrowingController@extend');
});

//##################### admin routes ##################################
Route::group(['middleware' => ['auth', 'admin']], function () {

    // manage books
    Route::get('/manage-books', 'BooksController@index');
    Route::get('/books-data', 'BooksController@datatable');
    Route::get('/books/add', 'BooksController@add');
    Route::post('/books/add', 'BooksController@postAdd');
    Route::get('/books/{book}/edit', 'BooksController@edit');
    Route::post('/books/{book}/edit', 'BooksController@postEdit');
    Route::get('/books/{book}/delete', 'BooksController@delete');

    Route::get('/approve-admins', 'UsersController@index');
    Route::get('/admins-data', 'UsersController@datatable');
    Route::get('/approve-admins/{admin}/approve', 'UsersController@approve');
    Route::get('/approve-admins/{admin}/delete', 'UsersController@delete');

    Route::get('/late-borrowers', 'UsersController@lateBorrowers');
    Route::get('/send-email/{idOrAll}', 'UsersController@sendEmail');

});
//##################### admin routes ##################################

