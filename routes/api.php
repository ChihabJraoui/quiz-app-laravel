<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Branches
Route::post('/branches/get-subjects', 'SubjectsController@getBranchSubjects');

// Quizzes
Route::get('/quizzes/{role}', 'QuizzesController@getQuizzes')->where(['role' => '[0,1]']);
Route::post('/quizzes/', 'QuizzesController@store');
Route::delete('/quizzes/{id}', 'QuizzesController@delete');
Route::post('/quizzes/{id}/activate', 'QuizzesController@activate');