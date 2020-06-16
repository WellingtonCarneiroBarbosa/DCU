<?php

namespace App\Http\Middleware;

use Closure;
use App\API\ApiResponses;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class ApiProtectedRoute extends BaseMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(ApiResponses::responseMessage('The jwt token is invalid', 403), 403);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(ApiResponses::responseMessage('The jwt token is expired', 403), 403);
            } else {
                return response()->json(ApiResponses::responseMessage('The jwt token was not found', 403), 403);
            }
        }

        return $next($request);
    }
}
