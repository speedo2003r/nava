<?php

namespace App\Http\Controllers\Api;

use App\Entities\Order;
use App\Entities\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LangRequest;
use App\Http\Resources\Orders\CartDetailResource;
use App\Http\Resources\Orders\CartResource;
use App\Http\Resources\Orders\OrderDetailResource;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Resources\Orders\SingleCartResource;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function cancelOrder(LangRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        $this->orderRepo->update([
            'status' => 'user_cancel'
        ],$order['id']);
        return $this->successResponse();
    }
    public function placeOrder(LangRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after:'.Carbon::now(),
            'time' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'map_desc' => 'required|string',
            'notes' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $data = array_filter($request->all());
        $order = $this->orderRepo->find($request['order_id']);
        $this->orderRepo->update([
            'date' => date('Y-m-d',strtotime($data['date'])),
            'time' => date('H:i:s',strtotime($data['time'])),
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'notes' => $data['notes'],
            'status' => 'confirmed'
        ],$order['id']);
        $total = $order->_price();
        $deposit = $total * settings('deposit') / 100;
        $order->orderInstallments()->create([
            'amount' => $deposit,
            'deposit' => true,
        ]);
        $msg_ar = 'هناك طلب جديد رقم '.$order['order_num'];
        $msg_en = 'there is new order no.'.$order['order_num'];
        $this->send_notify($order['user_id'],$msg_ar,$msg_en,$order['id'],$order['status']);
        return $this->successResponse();
    }
    public function MyOrders(LangRequest $request,$type)
    {
        $user = auth()->user();
        if($type == 'current'){
            $orders = $user->ordersAsUser()->whereNotIn('status',['done','pending','user_cancel'])->latest()->get();
        }else{
            $orders = $user->ordersAsUser()->where('status','done')->latest()->get();
        }
        return $this->successResponse(OrderResource::collection($orders));
    }
    public function OrderDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', Rule::exists('orders', 'id')]
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $allStatus = Order::userStatus();
        $methods = Order::orderMethods();
        return $this->successResponse([
            'methods' => $methods,
            'allStatus' => $allStatus,
            'status_name' => Order::userStatus($order['status']),
            'status' => $order['status'],
            'details' => new OrderDetailResource($order)
        ]);
    }
    public function OrderPay(LangRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', Rule::exists('orders', 'id')],
            'pay_type' => 'required|in:cash,visa,master,apple,stc',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $orderInstallment = $order->orderInstallments()->where('deposit','=',true)->first();
        if($orderInstallment){
            $orderInstallment->pay_type = $request['pay_type'];
            $orderInstallment->save();
            $this->orderRepo->update([
                'status' => 'under_work'
            ],$order['id']);
            $msg_ar = 'تم دفع العربون الخاص بالطلب رقم '.$order['order_num'];
            $msg_en = 'Deposit has been paid for order No.'.$order['order_num'];
            $this->send_notify($order['provider_id'],$msg_ar,$msg_en,$order['id'],$order['status']);
            return $this->successResponse();
        }
        return $this->ApiResponse('fail', 'لا يوجد أي قيمه سيتم دفعها في هذا الطلب');
    }
    public function finishOrderPay(LangRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', Rule::exists('orders', 'id')],
            'pay_type' => 'required|in:cash,visa,master,apple,stc',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $orderInstallment = $order->orderInstallments()->where('deposit','=',false)->first();
        if($orderInstallment){
            $orderInstallment->pay_type = $request['pay_type'];
            $orderInstallment->save();
            $this->orderRepo->update([
                'status' => 'under_work'
            ],$order['id']);
            $msg_ar = 'تم دفع العربون الخاص بالطلب رقم '.$order['order_num'];
            $msg_en = 'Deposit has been paid for order No.'.$order['order_num'];
            $this->send_notify($order['provider_id'],$msg_ar,$msg_en,$order['id'],$order['status']);
            return $this->successResponse();
        }
        return $this->ApiResponse('fail', 'لا يوجد أي قيمه سيتم دفعها في هذا الطلب');
    }

    public function finishOrder(LangRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', Rule::exists('orders', 'id')],
            'pay_type' => 'required|in:cash,visa,master,apple,stc',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $total = $order->_price();
        $orderInstallment = $order->orderInstallments()->where('deposit','=',true)->first();

        $order->orderInstallments()->create([
            'amount' => $total - $orderInstallment['amount'],
            'pay_type' => $request['pay_type'],
        ]);
        $this->orderRepo->update([
            'status' => 'done'
        ],$order['id']);
        $msg_ar = 'تم انهاء الطلب رقم '.$order['order_num'];
        $msg_en = 'Order No. has been completed'.$order['order_num'];
        $this->send_notify($order['provider_id'],$msg_ar,$msg_en,$order['id'],$order['status']);
        return $this->successResponse();
    }
    public function downloadPdf(LangRequest $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                 <div dir="ltr" style="text-align: right">{DATE j-m-Y H:m}</div>
                 <div dir="ltr" style="text-align: center">{PAGENO} of {nbpg}</div>'
            );
        }];
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $data = $order['contract'];
        $pdf = PDF::loadView('pdf', compact('data'), [], $config);
        return $pdf->download('contract.pdf');

    }
    public function viewContract(LangRequest $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $data = $order['contract'];
        return $this->successResponse($data ?? '');
    }
    public function acceptContract(LangRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', Rule::exists('orders', 'id')],
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $this->orderRepo->update([
            'contract_approved' => 1
        ],$order['id']);
        $msg_ar = 'تم الموافقه علي عقد الطلب رقم '.$order['order_num'];
        $msg_en = 'The application contract has been approved order No. '.$order['order_num'];
        $this->send_notify($order['provider_id'],$msg_ar,$msg_en,$order['id'],$order['status']);
        return $this->successResponse();
    }
    public function refuseContract(LangRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', Rule::exists('orders', 'id')],
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $this->orderRepo->update([
            'contract_approved' => 2
        ],$order['id']);
        $msg_ar = 'تم رفض عقد الطلب رقم '.$order['order_num'];
        $msg_en = 'The application contract has been disapproved order No. '.$order['order_num'];
        $this->send_notify($order['provider_id'],$msg_ar,$msg_en,$order['id'],$order['status']);
        return $this->successResponse();
    }

}
