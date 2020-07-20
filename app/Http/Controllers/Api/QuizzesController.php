<?php

namespace App\Http\Controllers\Api;

use App\Quiz;
use App\Http\Controllers\Controller;
use App\Student;
use App\Teacher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizzesController extends Controller
{

	public function getQuizzes($role)
	{

		if($role == 0)
		{
			$quizzes = Student::find(Auth::id())->branch->quizzes()->where('is_active', true)->get();
		}
		else
		{
			$quizzes = Teacher::find(Auth::id())->quizzes()
				->orderBy('created_at', 'desc')->get();
		}

		return response()->json($quizzes);
	}

	public function activate(Request $request, $id)
	{
		$subject = Quiz::find($id);
		$subject->is_active = $request->input('is_active');
		$subject->save();

		return response()->json(['error' => 0]);
	}

	public function store(Request $request)
	{
		return DB::transaction(function() use($request)
		{
			$subject_id = $request->input('subject_id');
			$name = $request->input('name');

			$quiz = Quiz::create([
				'subject_id' => $subject_id,
				'name' => $name
			]);

			$slugArray = explode(' ', $name);
			$slug = implode('-', $slugArray);

			$quiz->slug = $slug . '-' . $quiz->id;
			$quiz->save();

			return response()->json(['error' => 0]);
		});
	}

	public function delete($id)
	{
		return DB::transaction(function() use($id)
		{
			Quiz::destroy($id);

			return response()->json(['error' => 0]);
		});
	}
}
