<?php
namespace App\Http\Controllers\Api\Client\Cart\pipline;

use App\Repositories\OrderRepository;

class CheckIfExist{
    public function __construct(protected OrderRepository $orderRepo)
    {

    }

    public function handle($request,\Closure $next)
    {
        $user_id = auth()->check() ? auth()->id() : null;

        if($user_id != null){
            $order = $this->orderRepo->where('uuid',$request['uuid'])->where('user_id',$user_id)->where('live',0)->first();
        }else{
            $order = $this->orderRepo->where('uuid',$request['uuid'])->where('user_id',null)->where('live',0)->first();
        }
        $request['order'] = $order;
        $request['user_id'] = $user_id;
        return $next($request);
    }
}
