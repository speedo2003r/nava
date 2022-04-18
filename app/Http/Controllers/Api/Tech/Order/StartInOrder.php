<?php

namespace App\Http\Controllers\Api\Tech\Order;

use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StartInOrder extends Controller
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
            'status' => OrderStatus::INPROGRESS,
            'progress_start' => Carbon::now()->format('Y-m-d H:i'),
            'progress_type' => 'progress',
        ]);
        $order->user->notify(new \App\Notifications\Api\StartInOrder($order));
        return $this->successResponse();
    }
}
