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

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'middleware' => 'auth',
    'as' => 'dashboard.',
    'prefix' => 'dashboard',
    'namespace' => 'App\Http\Controllers',
], function () {
    Route::get('/index' , 'HomeController@index')->name('index');
    Route::get('/leaderboard' , 'HomeController@leaderboard')->name('leaderboard');
    Route::resource('users', UserController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::post('/schedules/status/change' , 'ScheduleController@statusChange')->name('schedules.status.change');
});

require __DIR__.'/auth.php';
