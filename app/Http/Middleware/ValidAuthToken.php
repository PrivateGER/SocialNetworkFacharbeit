<?php

namespace App\Http\Middleware;

use APIAuthentication\TokenManager;
use Closure;

class ValidAuthToken
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

        if(!isset($token) || empty($token) || strlen($token) !== 128) {
            return response(array(
                "err" => true,
                "msg" => "No token in valid format supplied."
            ), 400);
        }

        if(!TokenManager::verifyToken($token)) {
            return response(array(
                "err" => true,
                "msg" => "Invalid / expired token."
            ), 401);
        }

        return $next($request);
    }
}
