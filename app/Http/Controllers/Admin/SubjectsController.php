<?php

namespace App\Http\Controllers\Admin;

use App\Branch;
use App\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubjectsController extends Controller
{

    /*
     *  VIEWS
     */

    public function index()
    {
	    return view('admin.subjects.index');
    }


    /*
     * CRUD
     */

	public function getBranchSubjects(Request $request)
	{
		$branch_id = $request->input("branch_id");
		$branch = Branch::find($branch_id);

		$data = [
			'subjects' => $branch->subjects()->where('is_active', true)->get()
		];

		return view('subjects.index', $data);
	}

	public function getSubjects($id = null)
	{
		if($id == null)
		{
			$result = Subject::where('user_id', Auth::id())
				->with([
					'questions' => function($query)
					{
						$query->orderBy('created_at', 'desc');
					},
					'questions.answers' => function($query)
					{
						$query->orderBy('created_at', 'desc');
					}
				])
				->orderBy('created_at', 'desc')->get();
		}
		else
		{
			$result = Subject::where('id', $id)
				->with([
					'questions' => function($query)
						{
							$query->orderBy('created_at', 'desc');
						},
					'questions.answers' => function($query)
					{
						$query->orderBy('created_at', 'desc');
					}
				])->first();
		}

		return response()->json($result);
	}

	public function store(Request $request)
	{
		return DB::transaction(function() use($request)
		{
			$name = $request->input('name');

			$subject = Subject::create([
				'user_id' => Auth::id(),
				'branch_id' => 1,
				'name' => $name
			]);

			$rawSlug = explode(' ', $name);
			$slug = implode('-', $rawSlug);
			$subject->slug = $slug . '-' . $subject->id;
			$subject->save();

			return response()->json(['error' => 0]);
		});
	}

	public function update(Request $request, $id)
	{
		return DB::transaction(function() use($request, $id)
		{
			$name = $request->input('name');

			$subject = Subject::find($id);

			if($name != $subject->name)
			{
				$subject->name = $name;

				$rawSlug = explode(' ', $name);
				$slug = implode('-', $rawSlug);
				$subject->slug = $slug . '-' .$subject->id;
				$subject->save();
			}

			return response()->json(['error' => 0]);
		});
	}

	public function delete($id)
	{
		return DB::transaction(function() use($id)
		{

			Subject::Destroy($id);

			return response()->json(['error' => 0]);
		});
	}

	public function start($id)
	{
		return DB::transaction(function() use($id)
		{
			$subject = Subject::find($id);
			$subject->is_started = true;
			$subject->save();

			foreach ($subject->onlineUsers as $onlineUser)
			{
				$onlineUser->is_started = true;
				$onlineUser->save();
			}

			return response()->json(['error' => 0]);
		});
	}

}
