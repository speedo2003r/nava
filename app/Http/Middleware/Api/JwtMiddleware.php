<?php

namespace App\Http\Middleware\Api;

use App\Traits\ResponseTrait;
use Closure;
use Exception;
use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    use ResponseTrait;
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            # If user ban from admin
            if ($user->banned == true) {
                $msg  = trans('api.blocked');
                return $this->ApiResponse('blocked', $msg);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->ApiResponse('fail', trans('api.tokenIsInvalid'));
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->ApiResponse('fail', trans('api.tokenIsExpired'));
            }else{
                return $this->ApiResponse('fail', trans('api.authorizationTokenNotFound'));
            }
        }
        return $next($request);
    }
}
