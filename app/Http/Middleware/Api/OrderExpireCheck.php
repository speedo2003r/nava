<?php

namespace App\Http\Middleware\Api;
use App\Entities\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

use Auth;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderExpireCheck
{

    public function handle($request, Closure $next)
    {
        if($request['uuid']){
            $user_id = auth()->id();
            if($user_id != null){
                $order = Order::where('uuid',$request['uuid'])->where('user_id',$user_id)->where('live',0)->first();
            }else{
                $order = Order::where('uuid',$request['uuid'])->where('user_id',null)->where('live',0)->first();
            }
            if($order && Carbon::parse($order['updated_at'])->addHour(12)->format('Y-m-d H:i:s') < Carbon::now()->format('Y-m-d H:i:s')){
                $order->delete();
                $order->refresh();
            }
        }
        return $next($request);
    }
}
