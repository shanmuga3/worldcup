<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

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

Route::group(['prefix' => 'dev'], function () {
    Route::get('mail', function() {
        return resolveAndSendNotification("welcomeMail",10001);
    });
    Route::get('show__l--log', function() {
        $contents = \File::get(storage_path('logs/laravel.log'));
        echo '<pre>'.$contents.'</pre>';
    });
    Route::get('clear__l--log', function() {
        file_put_contents(storage_path('logs/laravel.log'),'');
    });
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('update-user-default', [HomeController::class,'updateUserDefaults'])->name('update_user_default');

Route::group(['middleware' => ['guest']], function () {
    Route::view('login','auth.login')->name('login');
    Route::post('authenticate',[AuthController::class,'authenticate'])->name('authenticate');
    Route::view('register','auth.register')->name('register');
    Route::post('create_user',[AuthController::class,'createUser'])->name('create_user');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard',[HomeController::class,'dashboard'])->name('dashboard');

    Route::get('logout', function () {
        session()->forget('url.intended');
        \Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});