<?php

namespace App\Http\Middleware;

use Closure;

class StartSession {

	public function handle($request, Closure $next)
	{
		session_start();

		return $next($request);
	}

}
