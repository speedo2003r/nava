<?php

namespace App\Http\Middleware\Api;

use App\Traits\ResponseTrait;
use Closure;

class CheckUserActive
{
    use ResponseTrait;
    public function handle($request, Closure $next)
    {
        if(auth('api')->check()){
            $user = auth()->user();
            if ($user->banned == 1){
                return response()->json([
                    'key' => 'is_banned',
                    'value' => 2,
                    'msg' =>'لقد تم حظرك من قبل الاداره'
                ]);
            }
        }
        return $next($request);
    }
}
