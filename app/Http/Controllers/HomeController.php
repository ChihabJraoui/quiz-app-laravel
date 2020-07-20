<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /*
     *  VIEWS
     */

    public function showDashboard()
    {
        return view('app.dashboard');
    }

    public function showHistories()
    {
        $data = [
            'histories' => Auth::user()->histories
        ];

        return view('app.histories', $data);
    }

    public function showCompleteRegistration()
    {
    	$branches = Branch::all();

    	$data = [
    		'branches' => $branches
	    ];

    	return view('app.completeRegistration', $data);
    }

    public function completeRegistration(Request $request)
    {
    	$user = User::find(Auth::id());
    	$user->branch_id = $request->input('branch_id');
    	$user->save();

    	return response()->redirectToRoute('app.dashboard');
    }

}
