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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/register/confirm/{token}', 'Auth\RegisterController@confirmEmail');

Route::get('/solution/add/{mainQuestion}/{subQuestion?}', 'SolutionController@getAdd')->name('solution_add');
Route::post('/solution/add/{mainQuestion}/{subQuestion?}', 'SolutionController@postAdd')->name('solution_add');

Route::get('/new_solutions', 'SolutionController@view_new_solutions');
Route::get('/new_solution_details/{id}', 'SolutionController@view_new_solution_details');
Route::get('/accept_new_solution/{id}', 'SolutionController@accept_solution');
Route::get('/decline_new_solution/{id}', 'SolutionController@decline_solution');

//questions
Route::get('/question_overview', 'MainquestionController@view_question_overview');
Route::get('/add_question', 'MainquestionController@view_add_question');
Route::post('/add_question', 'MainquestionController@add_question');

//chapters
Route::get('/add_chapter', 'ChapterController@show_add_chapter');
Route::post('/add_chapter', 'ChapterController@add_chapter');
Route::get('/edit_chapter/{id}', 'ChapterController@show_edit_chapter');
Route::post('/edit_chapter', 'ChapterController@edit_chapter');
Route::get('/add_subchapter', 'SubchapterController@show_add_subchapter');
Route::post('/add_subchapter', 'SubchapterController@add_subchapter');

//TEST
