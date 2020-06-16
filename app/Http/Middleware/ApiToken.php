<?php

namespace App\Http\Middleware;

use Closure;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->token;

        if(! $token) {
            return abort(403);
        }else if($token != config('app.support_api_key')) {
            return abort(403);
        }

        return $next($request);
    }
}
