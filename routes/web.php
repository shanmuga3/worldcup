<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::group(['middleware' => ['guest']], function () {
    Route::view('login','auth.login')->name('login');
    Route::post('authenticate',[AuthController::class,'authenticate'])->name('authenticate');
    Route::view('register','auth.register')->name('register');
    Route::post('create_user',[AuthController::class,'createUser'])->name('create_user');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', function () {
        return view('home');
    })->name('dashboard');

    Route::get('logout', function () {
        session()->forget('url.intended');
        \Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});