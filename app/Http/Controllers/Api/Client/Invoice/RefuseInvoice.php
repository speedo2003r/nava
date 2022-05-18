<?php

namespace App\Http\Controllers\Api\Client\Invoice;

use App\Entities\OrderBill;
use App\Enum\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefuseInvoice extends Controller
{
    use ResponseTrait;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'bill_id' => 'required|exists:order_bills,id',
            'refuse_reason' => 'required',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $orderBill = OrderBill::find($request['bill_id']);
        $orderBill->status = 2;
        $orderBill->refuse_reason = $request['refuse_reason'];
        $orderBill->save();
        $orderServices = $orderBill->orderServices;
        if(count($orderServices) > 0){
            foreach ($orderServices as $orderService){
                $orderService->status = 2;
                $orderService->save();
            }
        }
        $order = $orderBill->order;
        $technician = $order->technician;
        $technician->notify(new \App\Notifications\Api\RefuseInvoice($order));
        $admins = User::where('user_type',UserType::ADMIN)->where('notify',1)->get();
        $job = (new \App\Jobs\RefuseInvoice($admins,$order));
        dispatch($job);
        return $this->successResponse();
    }
}
