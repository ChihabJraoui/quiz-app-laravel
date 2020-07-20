<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/login', 'Auth\AdminLoginController@login');
Route::post('/logout', 'Auth\AdminLoginController@logout');


Route::group([
	'middleware' => 'auth:admin',
	'namespace' => 'Admin'
], function()
{
	Route::get('/', 'AdminController@showDashboard')->name('admin.dashboard');

	// Quizzes
	Route::get('/quizzes', 'QuizzesController@index')->name('admin.quizzes.index');
	Route::get('/quizzes/{id}/', 'QuizzesController@showQuiz')->name('admin.quizzes.show');

	Route::get('/quizzes/{id}/users', 'QuizzesController@getConnectedMembers');
	Route::get('/quizzes/{id}/start', 'QuizzesController@start');
	Route::get('/quizzes/{id}/questions-count', 'QuizzesController@getQuestionsCount');
	Route::get('/quizzes/{id}/results', 'QuizzesController@results');
	Route::get('/quizzes/{id}/close', 'QuizzesController@trash');

	// Subjects
	Route::get('/dashboard/subjects', 'SubjectsController@index')->name('admin.subjects.index');

	Route::get('/subjects/{id?}', 'SubjectsController@getSubjects');
	Route::post('/subjects/', 'SubjectsController@store');
	Route::put('/subjects/{id}', 'SubjectsController@update');
	Route::delete('/subjects/{id}', 'SubjectsController@delete');

	Route::get('/subjects/{id}/check-members', 'SubjectsController@checkMembers');
	Route::get('/subjects/{id}/start', 'SubjectsController@start');

	// questions
	Route::get('/dashboard/subjects/{id}/questions/', 'QuestionsController@index')->name('admin.questions.index');

	Route::get('/subjects/{id}/questions/', 'QuestionsController@getAllQuestions');
	Route::post('/questions/', 'QuestionsController@store');
	Route::put('/questions/{id}', 'QuestionsController@update');
	Route::delete('/questions/{id}', 'QuestionsController@delete');

	// Answers

	Route::get('/answers/{id}', 'AnswersController@getAnswer');
	Route::post('/answers/', 'AnswersController@store');
	Route::put('/answers/{id}', 'AnswersController@update');
	Route::delete('/answers/{id}', 'AnswersController@delete');
});
