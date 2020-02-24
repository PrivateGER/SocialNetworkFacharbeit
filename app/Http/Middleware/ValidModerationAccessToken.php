<?php

namespace App\Http\Middleware;

use APIAuthentication\TokenManager;
use App\AuthTokens;
use Closure;

class ValidModerationAccessToken
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

		$userPermissionLevel = AuthTokens::getTokenData($request->token)[0]->user->permission_level;

		if(AuthTokens::getTokenData($request->token)[0]->user->permission_level < 3) {
			return response(array(
				"err" => true,
				"msg" => "Unauthorized - You are not allowed to view this page."
			), 403);
		}

		$request->attributes->set('level', $userPermissionLevel);

		return $next($request);
	}
}
