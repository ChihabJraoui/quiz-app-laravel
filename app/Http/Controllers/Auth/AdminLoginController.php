<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

	public function showLoginForm()
	{
		return view('auth.login_admin');
	}

	public function login(Request $request)
	{
        $this->validateLogin($request);

		if ($this->hasTooManyLoginAttempts($request))
		{
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		$credentials = $this->credentials($request);

		if ($this->guard()->attempt($credentials, $request->has('remember')))
		{
			return $this->sendLoginResponse($request);
		}

		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}

	protected function validateLogin(Request $request)
	{
		$this->validate($request, [
			$this->username() => 'required',
			'password' => 'required',
		]);
	}

	protected function credentials(Request $request)
	{
		return $request->only($this->username(), 'password');
	}

	protected function sendLoginResponse(Request $request)
	{
		$request->session()->regenerate();

		$this->clearLoginAttempts($request);

		return redirect()->intended(route('admin.dashboard'));
	}

	protected function sendFailedLoginResponse(Request $request)
	{
		return redirect()->back()
			->withInput($request->only($this->username(), 'remember'))
			->withErrors([
				$this->username() => Lang::get('auth.failed'),
			]);
	}

	public function username()
	{
		return 'email';
	}

	public function logout(Request $request)
	{
		$this->guard()->logout();

		return redirect('/');
	}

	protected function guard()
	{
		return Auth::guard('admin');
	}
}
