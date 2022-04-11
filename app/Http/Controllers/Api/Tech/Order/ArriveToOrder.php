<?php

namespace App\Http\Controllers\Api\Tech\Order;

use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
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

        $title_ar = 'تم وصول التقني اليك الأن';
        $title_en = 'The technician has arrived for you now';
        $body_ar = 'تم وصول التقني اليك الأن';
        $body_en = 'The technician has arrived for you now';
        $order->user->notify(new \App\Notifications\Api\ArriveToOrder($title_ar,$title_en,$body_ar,$body_en,$order));
        return $this->successResponse();
    }
}
