<?php

namespace App\Http\Middleware;

use App\API\ApiResponses;
use App\Models\Systems\System;
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
        }else{
            try {
                $token = System::where('token', $token)->take(1)->get();

                if(count($token) != 1) {
                    return response()->json(ApiResponses::responseMessage('The access token is invalid', 403));
                }
            } catch(\Exception $e) {
                if(config('app.debug')) {
                    return response()->json(ApiResponses::responseMessage($e->getMessage(), 500));
                }

                return response()->json(ApiResponses::responseMessage('Error validating token', 500));
            }
        }

        return $next($request);
    }
}
