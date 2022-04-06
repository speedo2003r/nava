<?php

namespace App\Http\Controllers\Api\Client\Order;

use App\Entities\ReviewRate;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RateOrderTech extends Controller
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
            'rate' => 'required',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $technician = $order->technician;
        if($technician){
            ReviewRate::create([
                'user_id' => $user['id'],
                'order_id' => $order['id'],
                'rateable_id' => $technician['id'],
                'rateable_type' => get_class($technician),
                'rate' => $request['rate'],
            ]);
        }else{
            return $this->ApiResponse( 'fail', 'technician is undefined');
        }
        return $this->successResponse();
    }
}
