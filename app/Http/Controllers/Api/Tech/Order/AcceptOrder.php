<?php

namespace App\Http\Controllers\Api\Tech\Order;

use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcceptOrder extends Controller
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
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        $order->update([
            'technician_id' => $user['id'],
            'status' => OrderStatus::ACCEPTED,
        ]);
        $this->orderRepo->addStatusTimeLine($order['id'],OrderStatus::ACCEPTED);
        creatPrivateRoom($user['id'],$order['user_id'],$order['id']);
        $title_ar = 'تم الموافقه علي طلبك';
        $title_en = 'Your request has been approved';
        $body_ar = 'تم الموافقه علي طلبك وجاري تنفيذه الأن التقني في الطريق اليك';
        $body_en = 'Your request has been approved and is being implemented. The technician is on the way to you';
        $order->user->notify(new \App\Notifications\Api\AcceptOrder($title_ar,$title_en,$body_ar,$body_en,$order));
        return $this->successResponse();
    }
}