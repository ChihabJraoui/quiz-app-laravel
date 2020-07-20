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

Auth::routes();


Route::group(['middleware' => ['auth', 'student']], function()
{

	Route::group(['middleware' => 'completeRegistration'], function()
	{
		// Home
		Route::get('/', 'HomeController@showDashboard')->name('app.dashboard');

		// Quiz
		Route::get('/quizzes', 'QuizzesController@index')->name('app.quizzes');
		Route::get('/quizzes/{slug}', 'QuizzesController@showQuiz')->name('quizzes.show');

		Route::get('/quizzes/{id}/check', 'QuizzesController@check');
		Route::post('/quizzes/save', 'QuizzesController@save');

		// Histories
		Route::get('/histories', 'HomeController@showHistories')->name('app.histories');

		// Questions with answers
		Route::post('/questions-with-answers', 'QuestionController@getQuestionsWithAnswers');
	});

	// Other
	Route::get('/complete-registration', 'HomeController@showCompleteRegistration')
		->name('app.completeRegistration');
	Route::post('/complete-registration', 'HomeController@completeRegistration');

});

