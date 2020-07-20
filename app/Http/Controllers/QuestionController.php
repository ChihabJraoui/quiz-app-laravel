<?php

namespace App\Http\Controllers;

use App\Question;
use App\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
	public function getQuestionsWithAnswers(Request $request)
	{
		$subject = Quiz::find($request->id)->subject;
		$questions = Question::with('answers')->where('subject_id', $subject->id)->get();

		return response()->json($questions);
	}
}
