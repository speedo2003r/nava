<?php

namespace App\Http\Controllers\Api\Client\Order;

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
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        if(!in_array($order['status'],[OrderStatus::CREATED,OrderStatus::USERCANCEL])){
            $msg = app()->getLocale() == 'ar' ? 'لا يمكن الغاء هذا الطلب' : 'This request cannot be cancelled';
            return $this->ApiResponse('fail', $msg);
        }
        $this->orderRepo->update([
            'status' => 'user_cancel',
            'canceled_by' => auth()->id(),
        ],$order['id']);
        return $this->successResponse();
    }
}
