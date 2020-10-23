<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use Closure;

class HasActiveSubscription
{
	/*To be run after auth or auth:api. Checks whether user has a valid subscription.*/
    public function handle($request, Closure $next)
    {
		$user = Auth::user();
		
		if ($user->subscription == null || !$user->subscription->active) {
			return Response::json("Valid subscription required.", 403);
		}
		
        return $next($request);
    }
}
