<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Subject;
use App\Question;

class QuestionsController extends Controller
{

	public function index($subject_id)
	{
		$data = [
			'subject' => Subject::find($subject_id)
		];

		return view('admin.questions.index', $data);
	}

	public function store(Request $request)
	{
		return DB::transaction(function() use($request)
		{
			$subject_id = $request->input('subject_id');
			$question = $request->input('question');

			$createdQuestion = Question::create([
				'subject_id' => $subject_id,
				'question' => $question
			]);

			return response()->json([
				'error' => 0,
				'question' => $createdQuestion
			]);
		});
	}

	public function update(Request $request, $id)
	{
		return DB::transaction(function() use($request, $id)
		{
			$question = $request->input('question');

			$updatedQuestion = Question::find($id);

			$updatedQuestion->question = $question;
			$updatedQuestion->save();

			return response()->json([
				'error' => 0,
				'question' => $updatedQuestion
			]);
		});
	}

	public function delete($id)
	{
		return DB::transaction(function() use($id)
		{
			Question::destroy($id);

			return response()->json([
				'error' => 0
			]);
		});
	}

}