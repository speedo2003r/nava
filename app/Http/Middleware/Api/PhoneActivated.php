<?php

namespace App\Http\Middleware\Api;

use App\Traits\ResponseTrait;
use Closure;

class PhoneActivated
{
    use ResponseTrait;
    public function handle($request, Closure $next)
    {
        if (auth('api')->check() && auth('api')->user()->active != 1) {
            return $this->respond(null, 'success', 'برجاء تفعيل الهاتف');
        }
        if(auth('api')->check() && auth('api')->user()->active == 1){
            $user = auth()->user();
            if ($user->banned == 1){
                return response()->json([
                    'key' => 'is_banned',
                    'value' => 2,
                    'msg' =>'لقد تم حظرك من قبل الاداره'
                ]);
            }
            if ($user->active == 0){
                return response()->json([
                    'key' => 'not_active',
                    'value' => 3,
                    'msg' =>'يرجي تفعيل الهاتف قبل الاستكمال'
                ]);
            }

            if ($user->accepted == 0) {
                return response()->json([
                    'key' => 'not_accepted',
                    'value' => 4,
                    'msg' =>'برجاء الرجوع للاداره لتفعيل حسابك'
                ]);
            }
        }
        return $next($request);
    }
}
