<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Quiz;
use Illuminate\Support\Facades\DB;

class QuizzesController extends Controller
{
	public function index()
	{
		$data = [
			'subjects' => Auth::user()->subjects
		];

		return view('admin.quizzes.index', $data);
	}

	public function showQuiz($id)
	{
		$data = [
			'quiz' => Quiz::find($id)
		];

		return view('admin.quizzes.quiz', $data);
	}

	public function getConnectedMembers($id)
	{
		$users_count = Quiz::find($id)->students->count();

		return response()->json($users_count);
	}

	public function start($id)
	{
		return DB::transaction(function() use($id)
		{
			$quiz = Quiz::find($id);
			$quiz->is_started = true;
			$quiz->save();

			foreach($quiz->students as $student)
			{
				$student->is_started = true;
				$student->save();
			}

			return response()->json(['error' => 0]);
		});
	}

	public function getQuestionsCount($id)
	{
		$count = Quiz::find($id)->subject->questions->count();

		return response()->json($count);
	}

	public function results($id)
	{
		$results = [];

		$quiz = Quiz::onlyTrashed()->where('id', $id)->first();
		$students = $quiz->students()->orderBy('score','desc')->get();

		foreach ($students as $student)
		{
			$results[] = [
				'name' => $student->getFullname(),
				'score' => $student->pivot->score == null ? '??' : $student->pivot->score
			];
		}

		return response()->json($results);
	}

	public function trash($id)
	{
		Quiz::destroy($id);

		return response()->json(['success' => 'Quiz succesfuly Deleted.']);
	}
}
