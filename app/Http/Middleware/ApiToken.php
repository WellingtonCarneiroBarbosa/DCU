<?php

namespace App\Http\Middleware;

use App\API\ApiResponses;
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
            return response()->json(ApiResponses::responseMessage('The access token was not found', 403));
        }else if($token != config('app.support_api_key')) {
            return response()->json(ApiResponses::responseMessage('The access token is invalid', 403));
        }

        return $next($request);
    }
}
