<?php

namespace App\Http\Controllers\Api\Client\Order;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderGuarantee extends Controller
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
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $guarantee = $order->guarantee;
        if($guarantee){
            if($guarantee['start_date'] <= Carbon::now()->format('Y-m-d') && $guarantee['end_date'] >= Carbon::now()->format('Y-m-d')){
                $guarantee->status = 1;
                $guarantee->technical_id = $order['technician_id'];
                $guarantee->save();
            }else{
                $msg = app()->getLocale() == 'ar' ? 'لقد انتهت فترة الضمان' : 'Warranty period has expired';
                return $this->ApiResponse( 'fail', $msg);
            }
        }else{
            $msg = app()->getLocale() == 'ar' ? 'لا يوجد لهذا الطلب ضمان' : 'There is no guarantee for this order';
            return $this->ApiResponse( 'fail', $msg);
        }
        return $this->successResponse();
    }
}
