<?php

namespace App\Http\Controllers\Api\Tech\Order;

use App\Enum\OrderStatus;
use App\Enum\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArriveToOrder extends Controller
{
    use ResponseTrait;
    public function __construct(protected OrderRepository $orderRepo)
    {

    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL'
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        $order->update([
            'status' => OrderStatus::ARRIVED,
        ]);

        $this->orderRepo->addStatusTimeLine($order['id'],OrderStatus::ARRIVED);
        $order->user->notify(new \App\Notifications\Api\ArriveToOrder($order));

        $admins = User::where('user_type',UserType::ADMIN)->where('notify',1)->get();
        $job = (new \App\Jobs\TechArriveToOrder($admins,$order));
        dispatch($job);
        return $this->successResponse();
    }
}
