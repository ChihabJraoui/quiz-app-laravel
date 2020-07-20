<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnswersController extends Controller
{

	public function getAnswer($id)
	{
		$answer = Answer::find($id);

		return response()->json($answer);
	}

	public function store(Request $request)
	{
		return DB::transaction(function() use($request)
		{
			$question_id = $request->input('question_id');
			$answer = $request->input('answer');

			$created_answer = Answer::create([
				'question_id' => $question_id,
				'answer' => $answer,
				'is_correct' => false
			]);

			return response()->json([
				'error' => 0,
				'answer' => $created_answer
			]);
		});
	}

	public function update(Request $request, $id)
	{
		return DB::transaction(function() use($request, $id)
		{
			$answer = $request->input('answer');

			$updatedAnswer = Answer::find($id);

			$updatedAnswer->answer = $answer;
			$updatedAnswer->save();

			return response()->json([
				'error' => 0,
				'answer' => $updatedAnswer
			]);
		});
	}

	public function delete($id)
	{
		return DB::transaction(function() use($id)
		{
			Answer::destroy($id);

			return response()->json([
				'error' => 0
			]);
		});
	}

}
