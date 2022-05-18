<?php

namespace App\Http\Middleware\Api;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtRefreshMiddleware extends BaseMiddleware
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
        try{
            $newToken = JWTAuth::refresh();
            JWTAuth::setToken($newToken);
            $user = \PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::toUser($newToken);
        }catch(\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException $e){
            return $this->respond(null,'fails', $e->getMessage());

        }
        return $next($request);
    }
}
