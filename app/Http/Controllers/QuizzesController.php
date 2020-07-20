<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizzesController extends Controller
{

	function __construct()
	{
		$this->middleware('student');
	}

	public function index()
	{
		return view('app.quizzes.index');
	}

	public function showQuiz($slug)
	{
		$quiz = Quiz::withTrashed()->where('slug', $slug)->first();

		if($quiz->trashed())
		{

		}
		else
		{
			$quiz_user = Student::find(Auth::id())->quizzes()->where('quiz_id', $quiz->id)->first();

			if($quiz_user == null)
			{
				Student::find(Auth::id())->quizzes()->attach($quiz->id, [
					'score' => null,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]);
			}

			$data = [
				'quiz' => $quiz
			];

			return view('app.quiz', $data);
		}
	}

	public function check($id)
	{
		$response = [
			'quiz' => Quiz::find($id),
			'user' => Auth::user()
		];

		return response()->json($response);
	}

	public function save(Request $request)
	{
		$quiz_id = $request->input('quiz_id');
		$score = $request->input('score');

		$student = Student::find(Auth::id());
		$student->is_started = false;
		$student->save();

		$student->quizzes()->updateExistingPivot($quiz_id, [
			'score' => $score,
			'updated_at' => Carbon::now()
		]);

		return response()->json(['error' => 0]);
	}

}