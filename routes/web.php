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
    Route::get('/test', function () {
        $nextTick = 1212122123434;
        $ticks = 1122112;
        \App\Models\ServerData::upsert([
            [
                'id' => 1,
                'key' => 'next.wirtschafts.Tick',
                'value' => $nextTick
            ],
            [
                'id' => 2,
                'key' => 'wirtschafts.Tick',
                'value' => $ticks
            ],
        ], 'value');
    });
Route::group(['middleware' => ['web', 'checker']], function () {
    Route::get('/crown', function () {
        echo 'Finish';
    });
});

    Route::prefix('admin')->group(function() {
        Route::resource('/', 'App\Http\Controllers\Admin\IndexController', ["as"=>"admin"]);
        Route::resource('server', 'App\Http\Controllers\Admin\ServerController', ["as"=>"admin"]);
        Route::resource('users', 'App\Http\Controllers\Admin\UserController', ["as"=>"admin"]);
        Route::resource('translate', 'App\Http\Controllers\Admin\TranslationController', ["as"=>"admin"]);
        Route::resource('buildings', 'App\Http\Controllers\Admin\BuildingsController', ["as"=>"admin"]);
        Route::resource('buildingsdata', '\App\Http\Controllers\Admin\BuildingsDataController', ["as"=>"admin"]);
        Route::get('buildingsadd', '\App\Http\Controllers\Admin\BuildingsController@getDataCsv');
        Route::resource('researchs', '\App\Http\Controllers\Admin\ResearchsController', ["as"=>"admin"]);
        Route::resource('researchsdata', '\App\Http\Controllers\Admin\ResearchsDataController', ["as"=>"admin"]);
        Route::get('researchsadd', '\App\Http\Controllers\Admin\ResearchsController@getDataCsv');
    });

    Route::resource('buildings', 'App\Http\Controllers\BuildingsController');
    Route::resource('researchs', 'App\Http\Controllers\ResearchsController');
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
