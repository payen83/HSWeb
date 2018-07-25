<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Auth;

class SuperAdmin
{

    public function handle($request, Closure $next)
	{
	    if (Auth::check() && Auth::user()->role == 'SuperAdmin') {
	        return $next($request);
	    }
	    else {
	        return redirect('error');
	    }
	}
}