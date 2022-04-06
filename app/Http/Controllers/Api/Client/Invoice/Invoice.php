<?php

namespace App\Http\Controllers\Api\Client\Invoice;

use App\Entities\OrderBill;
use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\OrderBillResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Invoice extends Controller
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
        return $this->successResponse(OrderBillResource::make($orderBill));
    }
}
