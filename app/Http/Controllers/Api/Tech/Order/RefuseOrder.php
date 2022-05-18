<?php

namespace App\Http\Controllers\Api\Tech\Order;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefuseOrder extends Controller
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
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        $user->refuseOrders()->syncWithOutDetaching([$order['id']=>['notes' => $request['notes']]]);
        return $this->successResponse();
    }
}
