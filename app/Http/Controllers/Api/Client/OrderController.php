<?php

namespace App\Http\Controllers\Api\Client;

use App\Entities\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LangRequest;
use App\Http\Resources\Orders\OrderDetailResource;
use App\Http\Resources\Orders\OrderResource;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ResponseTrait;
    use NotifyTrait;

    public $orderRepo, $userRepo, $categoryRepo, $service, $orderService;

    public function __construct(OrderServiceRepository $orderService, ServiceRepository $service, OrderRepository $order, UserRepository $user, CategoryRepository $category)
    {
        $this->userRepo = $user;
        $this->orderRepo = $order;
        $this->orderService = $orderService;
        $this->service = $service;
        $this->categoryRepo = $category;
    }

    public function MyOrders(LangRequest $request,$type)
    {
        $user = auth()->user();
        if($type == 'current'){
            $orders = $user->ordersAsUser()->where('live',1)->whereNotIn('status',['finished','canceled'])->latest()->get();
        }else{
            $orders = $user->ordersAsUser()->where('live',1)->where('status','finished')->latest()->get();
        }
        return $this->successResponse(OrderResource::collection($orders));
    }
    public function OrderDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if($order['live'] == 0){
            $msg = 'لم يتم تنفيذ الطلب بعد';
            return $this->ApiResponse( 'fail', $msg);
        }

        if($order->bills()->where('order_bills.status',0)->exists()){
            $allStatus = Order::userStatusWithBill();
            $status = 'new-invoice';
            $invoice = true;
            $bill_id = $order->bills()->where('order_bills.status',0)->first()['id'];
        }else{
            $allStatus = Order::userStatus();
            $status = $order['status'];
            $invoice = false;
            $bill_id = 0;
        }
        $order->refresh();
        return $this->successResponse([
            'allStatus' => $allStatus,
            'status_name' => $status == 'new-invoice' ? Order::userStatusWithBill($status) : Order::userStatus($status),
            'status' => $status,
            'details' => new OrderDetailResource($order),
            'invoice' => $invoice,
            'pay_type'=> $order['pay_type'] ? __($order['pay_type']) : '',
            'bill_id' => $bill_id,
        ]);
    }
}
