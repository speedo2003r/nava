<?php

namespace App\Http\Controllers\Api\Tech\Order;

use App\Entities\OrderGuarantee;
use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinishOrder extends Controller
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
        if($order['status'] == 'finished'){
            $msg = app()->getLocale() == 'ar' ? 'تم انهاء العمل بالفعل' : 'The work has already been completed';
            return $this->ApiResponse('fail',$msg);
        }
        if($order['status'] != 'finished'){

            $order->update([
                'status' => OrderStatus::FINISHED,
                'progress_end' => Carbon::now()->format('Y-m-d H:i'),
            ]);
            $category = $order->category;
            if($category['guarantee_days'] > 0){
                OrderGuarantee::create([
                    'order_id' => $order['id'],
                    'start_date' => Carbon::now()->format('Y-m-d'),
                    'end_date' => Carbon::now()->addDay($category['guarantee_days']),
                ]);
            }

            $this->orderRepo->addStatusTimeLine($order['id'],OrderStatus::FINISHED);
            $user = $order->user;
            $user->notify(new \App\Notifications\Api\FinishOrder($order));
        }
        return $this->successResponse();
    }
}
