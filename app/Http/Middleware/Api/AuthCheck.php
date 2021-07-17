<?php

namespace App\Http\Middleware\Api;
use Illuminate\Support\Facades\Route;

use Auth;
use Closure;
use Tymon\JWTAuth\JWTAuth;

class AuthCheck
{
    public function handle($request, Closure $next)
    {
        $token = \Tymon\JWTAuth\Facades\JWTAuth::getToken();
        if($token){
            $user = \Tymon\JWTAuth\Facades\JWTAuth::toUser($token);
        }
        return $next($request);
    }
}
