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


Route::get('todo/list',['uses' => 'TodoController@list']);
Route::post('todo/add',['uses' => 'TodoController@todoAdd']);
Route::post('todo/update',['uses' => 'TodoController@todoUpdate']);
Route::post('todo/delete',['uses' => 'TodoController@todoDelete']);
