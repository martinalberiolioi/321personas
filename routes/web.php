<?php

use App\Colaborator;
use App\Skill;
use Illuminate\Support\Facades\Input;
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

Route::view('/', 'welcome');

/**
 * Este metodo engloba index, create, store, update y delete
 * Es decir, el resource solo se da cuenta a cual dirigirse
 */
Route::resource('personas','ColabController');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
