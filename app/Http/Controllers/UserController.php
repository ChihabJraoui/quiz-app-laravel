<?php

namespace App\Http\Controllers;


use Auth;
use App\User;


class UserController extends Controller
{

	/**
	 * Show Profile View
	 *
	 * @param $username
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getProfileView($username)
	{
		$data = [
			'user' => User::where('username', $username)->firstOrFail()
		];

		return view('profile.profile', $data);
	}

}