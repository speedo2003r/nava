<?php

namespace App\Http\Controllers\Api\Tech\Order;

use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CancelOrder extends Controller
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
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'notes' => 'required|string|max:2000',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        $order->update([
            'status' => OrderStatus::USERCANCEL,
            'cancellation_reason' => $request['notes'],
            'canceled_by' => auth()->id(),
        ]);

        $this->orderRepo->addStatusTimeLine($order['id'],OrderStatus::USERCANCEL);
        $title_ar = 'تم الغاء الطلب رقم '.$order['order_num'];
        $title_en = 'The order NO. '.$order['order_num'].' was canceled';
        $body_ar =  'تم الغاء الطلب رقم '.$order['order_num'].' من قبل التقني';
        $body_en = 'The order NO. '.$order['order_num'].' was canceled by the technician';
        $order->user->notify(new \App\Notifications\Api\CancelOrder($title_ar,$title_en,$body_ar,$body_en,$order));
        return $this->successResponse();
    }
}