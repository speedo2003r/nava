<?php

namespace App\Http\Middleware\Api;
use Illuminate\Support\Facades\Route;

use Auth;
use Closure;

class AuthCheck
{
    protected $JWTAuth;
    public function __construct(\PHPOpenSourceSaver\JWTAuth\JWTAuth $JWTAuth)
    {
        $this->JWTAuth = $JWTAuth;
    }

    public function handle($request, Closure $next)
    {
        $token = $this->JWTAuth->getToken();
        if($token){
            $user = $this->JWTAuth->toUser($token);
        }
        return $next($request);
    }
}
