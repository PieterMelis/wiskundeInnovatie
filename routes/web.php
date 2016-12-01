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

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/register/confirm/{token}', 'Auth\RegisterController@confirmEmail');
Route::get('/new_solutions', 'SolutionController@view_new_solutions');
Route::get('/add_question', 'MainquestionController@view_add_question');