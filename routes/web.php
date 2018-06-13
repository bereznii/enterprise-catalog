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
Route::get('/list', 'ListController@index')->name('list');
Route::post('/list/{info}','ListController@search');
Route::post('/order','ListController@order');


//CRUD
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home','HomeController@order_ajax');
Route::post('/home/{info}','HomeController@search');


Route::get('/home/read/{id}', 'HomeController@read');

Route::get('/home/create', 'HomeController@create');
Route::post('/createajax', 'HomeController@accessible_supervisor_ajax');
Route::post('/do_create', 'HomeController@do_create');

Route::get('/home/delete/{id}', 'HomeController@delete');

Route::get('/home/update/{id}', 'HomeController@update')->name('update');
Route::post('/do_update', 'HomeController@do_update');
