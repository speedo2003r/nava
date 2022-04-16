<?php

namespace App\Http\Middleware\Api;
use Illuminate\Support\Facades\Route;

use Auth;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthCheck
{

    public function handle($request, Closure $next)
    {
        $token = JWTAuth::getToken();
        if($token){
            $user = JWTAuth::toUser($token);
        }
        return $next($request);
    }
}
