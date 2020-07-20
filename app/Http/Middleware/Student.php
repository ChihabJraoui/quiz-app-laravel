<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Student
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 * @internal param null $guard
	 */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role == 1)
	    {
			abort(403, 'Access Denied');
	    }

        return $next($request);
    }
}
