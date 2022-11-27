<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
Route::group(['middleware' => ['web', 'checker']], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::prefix('admin')->group(function() {
        Route::resource('buildings', 'App\Http\Controllers\Admin\BuildingsController', ["as"=>"admin"]);
        Route::resource('/', 'App\Http\Controllers\Admin\IndexController', ["as"=>"admin"]);
        Route::resource('users', 'App\Http\Controllers\Admin\UserController', ["as"=>"admin"]);
        Route::resource('buildingsdata', 'App\Http\Controllers\Admin\BuildingsDataController', ["as"=>"admin"]);
        Route::resource('translate', 'App\Http\Controllers\Admin\TranslationController', ["as"=>"admin"]);
        Route::get('buildingsadd', '\App\Http\Controllers\Admin\BuildingsController@getDataCsv');
    });

    Route::resource('buildings', 'App\Http\Controllers\BuildingsController');
});

Route::get('login/{id}', function($id) {
    $user = \App\Models\User::where('token', $id)->first();
    if ($user) {
        Auth::loginUsingId($user->id);
    }
    return redirect('/');
});

    Route::get('logout', function () {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    });
