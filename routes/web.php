<?php


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

//Tree
//Route::get('/tree/none', 'TreeController@show');
Route::get('/tree/{id}', 'TreeController@show');

Auth::routes();

//List
Route::get('/list', 'ListController@index')->middleware('auth')->name('list');
Route::match(['get','post'], '/list/order/{info}','ListController@order')->middleware('auth');

//CRUD
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/refresh', 'HomeController@refresh')->middleware('auth');
Route::match(['get','post'], '/home/order/{info}','HomeController@order')->middleware('auth');
Route::get('/home/read/{id}', 'HomeController@read')->middleware('auth');
Route::get('/home/create', 'HomeController@create')->middleware('auth');
Route::post('/home/do_create', 'HomeController@do_create')->middleware('auth');
Route::post('/home/accessible_supervisor', 'HomeController@accessible_supervisor_ajax')->middleware('auth');
Route::get('/home/delete/{id}', 'HomeController@delete')->middleware('auth');
Route::get('/home/update/{id}', 'HomeController@update')->middleware('auth')->name('update');
Route::post('/home/do_update', 'HomeController@do_update')->middleware('auth');
