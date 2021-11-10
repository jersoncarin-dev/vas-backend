<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyQueryToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->has('token') && $request->get('token') === csrf_token()) {
            return $next($request);
        }
        
        return abort(401);
    }
}
