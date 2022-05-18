<?php

namespace App\Http\Controllers\Api\Client\Invoice;

use App\Entities\OrderBill;
use App\Enum\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcceptInvoice extends Controller
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
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $orderBill = OrderBill::find($request['bill_id']);
        $orderBill->status = 1;
        $orderBill->save();
        $orderServices = $orderBill->orderServices;
        if(count($orderServices) > 0){
            foreach ($orderServices as $orderService){
                $orderService->status = 1;
                $orderService->save();
            }
        }
        $order = $orderBill->order;
        $technician = $order->technician;
        $order->vat_amount = $order->tax() - $order['increase_tax'];
        $order->final_total = $order->price() - $order['increased_price'];
        $order->total_services = $order->orderServices('order_services.status',1)->count();
        $order->save();
        $technician->notify(new \App\Notifications\Api\AcceptInvoice($order));
        $admins = User::where('user_type',UserType::ADMIN)->where('notify',1)->get();
        $job = (new \App\Jobs\AcceptInvoice($admins,$order));
        dispatch($job);
        return $this->successResponse();
    }
}
