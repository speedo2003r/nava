<?php

namespace App\Http\Controllers\Api\Tech;

use App\Entities\Income;
use App\Entities\Order;
use App\Entities\OrderBill;
use App\Entities\OrderGuarantee;
use App\Entities\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\ServiceResource;
use App\Http\Resources\Orders\TechnicalGuaranteeOrderCollection;
use App\Http\Resources\Orders\TechnicalOrderDetailsResource;
use App\Http\Resources\Orders\TechnicalOrderCollection;
use App\Models\Room;
use App\Notifications\Api\FinishOrder;
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

    public function NewOrders(Request $request)
    {
        $user = auth()->user();
        $orders = $user->orders()->where('orders.status','created')->whereDoesntHave('refuseOrders',function ($query) use ($user){
            $query->where('refuse_orders.user_id',$user['id']);
        })->orderBy('created_date','desc')->paginate(10);
        return $this->successResponse(TechnicalOrderCollection::make($orders));
    }
    public function CurrentOrders(Request $request)
    {
        $user = auth()->user();
        if($user['user_type'] == 'company'){
            $orders = Order::join('users','users.id','orders.technician_id')
                ->whereDoesntHave('refuseOrders')
                ->where('users.company_id',$user['id'])
                ->orderBy('created_date','desc')
                ->paginate(10);
        }else{
            $orders = $user->ordersAsTech()->whereNotIn('orders.status', ['finished','created'])->whereDoesntHave('refuseOrders')->orderBy('created_date','desc')->paginate(10);
        }
        return $this->successResponse(TechnicalOrderCollection::make($orders));
    }
    public function FinishedOrders(Request $request)
    {
        $user = auth()->user();
        if($user['user_type'] == 'company'){
            $orders = Order::join('users','users.id','orders.technician_id')
                ->whereDoesntHave('refuseOrders')
                ->where('users.company_id',$user['id'])
                ->where('orders.status', 'finished')
                ->orderBy('created_date','desc')
                ->paginate(10);
        }else {
            $orders = $user->ordersAsTech()->where('orders.status', 'finished')->orderBy('created_date','desc')->paginate(10);
        }
        return $this->successResponse(TechnicalOrderCollection::make($orders));
    }
    public function GuaranteeOrders(Request $request)
    {
        $user = auth()->user();

        if($user['user_type'] == 'company'){
            $orders = OrderGuarantee::join('users','users.id','order_guarantees.technical_id')
                ->where('users.company_id',$user['id'])
                ->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))
                ->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))
                ->where('status', 1)
                ->where('solved', 0)
                ->latest()
                ->paginate(10);
        }else {
            $orders = $user->GuaranteeOrders()->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))->where('status', 1)->where('solved', 0)->paginate(10);
        }
        return $this->successResponse(TechnicalGuaranteeOrderCollection::make($orders));
    }

    public function acceptOrder(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL'
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        $order->update([
            'technician_id' => $user['id'],
            'status' => 'accepted',
        ]);
        creatPrivateRoom($user['id'],$order['user_id'],$order['id']);
        $this->send_notify($order['user_id'],'تم الموافقه علي طلبك وجاري تنفيذه الأن التقني في الطريق اليك','Your request has been approved and is being implemented. The technician is on the way to you',$order['id'],$order['status'],'accepted');
        return $this->successResponse();
    }
    public function arriveToOrder(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL'
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        $order->update([
            'status' => 'arrived',
        ]);
        $this->send_notify($order['user_id'],'تم وصول التقني اليك الأن','The technician has arrived for you now',$order['id'],$order['status'],'arrived');
        return $this->successResponse();
    }
    public function StartInOrder(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL'
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        $order->update([
            'status' => 'in-progress',
            'progress_start' => Carbon::now()->format('Y-m-d H:i'),
            'progress_type' => 'progress',
        ]);
        $this->send_notify($order['user_id'],'تم بدء العمل','Work has begun',$order['id'],$order['status'],'inProgress');
        return $this->successResponse();
    }
    public function FinishOrder(Request $request)
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
                'status' => 'finished',
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

            $user = $order->user;
            $title_ar = 'تم انهاء الطلب';
            $title_en = 'there is order has been completed';
            $msg_ar = 'تم انهاء الطلب رقم '.$order['order_num'];
            $msg_en = 'Order No. has been completed'.$order['order_num'];
            $user->notify(new FinishOrder($title_ar,$title_en,$msg_ar,$msg_en,$order));
        }
        return $this->successResponse();
    }
    public function refuseOrder(Request $request)
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
    public function cancelOrder(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'notes' => 'required|string|max:2000',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        $order->update([
            'status' => 'canceled',
            'cancellation_reason' => $request['notes'],
            'canceled_by' => auth()->id(),
        ]);
        $this->send_notify($order['user_id'],'تم الغاء الطلب من قبل التقني','The request was canceled by the technician',$order['id'],$order['status'],'canceled');
        return $this->successResponse();
    }
    public function orderDetails(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL'
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        return $this->successResponse(TechnicalOrderDetailsResource::make($order));
    }

    public function addServiceToOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'sometimes|exists:services,id,deleted_at,NULL',
            'category_id' => 'required|exists:categories,id,deleted_at,NULL',
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'counter' => 'required|in:up,down',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        if($order['pay_status'] == 'done'){
            $msg = app()->getLocale() == 'ar' ? 'تم سداد الطلب بالفعل من قبل العميل': 'The order has already been paid by the customer';
            return $this->ApiResponse('fail', $msg);
        }
        $orderBill = OrderBill::where('status',0)->where('order_id',$request['order_id'])->whereHas('orderServices')->first();
        if($orderBill){
            $orderService = OrderService::where('status',0)->where('order_id', $order['id'])->where('service_id', $request['service_id'])->first();
            if ($request['counter'] == 'up') {
                $service = $this->service->find($request['service_id']);
                $tax = ($service['price'] * settings('tax')) / 100;
                $orderBill->update([
                    'vat_amount' => $orderBill['vat_amount'] + $tax,
                    'price' => $orderBill['price'] + $service['price'],
                ]);
                if ($orderService == null) {
                    $orderBill->orderServices()->create([
                        'title' => $service['title'],
                        'type' => $service['type'],
                        'status' => 0,
                        'order_id' => $order['id'],
                        'category_id' => $request['category_id'],
                        'service_id' => $service['id'],
                        'price' => $service['price'],
                        'tax' => ($service['price'] * settings('tax') ?? 0) / 100,
                    ]);
                } else {
                    $orderService->count = $orderService->count + 1;
                    $orderService->save();
                }
            } else {
                $serviceData = $orderService;
                if ($orderService == null) {
                    $serviceData = $this->service->find($request['service_id']);
                    $tax = ($serviceData['price'] * settings('tax') ?? 0) / 100;
                } else {
                    $tax = $orderService['tax'];
                    if ($orderService['count'] == 1) {
                        $orderService->forceDelete();
                    }else{
                        $orderService->count = $orderService->count - 1;
                        $orderService->save();
                    }
                }
                if(count($orderBill->orderServices) == 0){
                    $orderBill->forceDelete();
                }else{
                    $orderBill->update([
                        'vat_amount' => $orderBill['vat_amount'] - $tax,
                        'price' => $orderBill['price'] - $serviceData['price'],
                    ]);
                }
            }
        }else{
            $service = $this->service->find($request['service_id']);
            $tax = ($service['price'] * settings('tax')) / 100;
            $orderBill = OrderBill::create([
                'order_id'=>$order['id'],
                'vat_amount' => $tax,
                'price' => $service['price'],
                'type'=>'service',
                'status'=>0,
            ]);
            $orderBill->orderServices()->create([
                'title' => $service['title'],
                'type' => $service['type'],
                'status' => 0,
                'order_id' => $order['id'],
                'category_id' => $request['category_id'],
                'service_id' => $service['id'],
                'price' => $service['price'],
                'tax' => ($service['price'] * settings('tax') ?? 0) / 100,
            ]);
        }
        $orderBill = OrderBill::find($orderBill['id']);
        $msg = app()->getLocale() == 'ar' ? 'تم الاضافه بنجاح' : 'successfully add';
        return $this->ApiResponse('success',$msg,[
            'orderBill_id' => $orderBill != null ? $orderBill['id'] : 0,
            'tax' => $orderBill != null ? $orderBill['vat_amount'] : 0,
            'price' => $orderBill != null ? $orderBill->_price() : 0,
        ]);
    }
    public function servicesOrder(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'orderBill_id' => 'required|exists:order_bills,id',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $user = auth()->user();
        $orderBill = OrderBill::find($request['orderBill_id']);
        return $this->successResponse(ServiceResource::make($orderBill));
    }
    public function delServiceOrder(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_service_id' => 'required|exists:order_services,id,deleted_at,NULL',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $orderService = OrderService::find($request['order_service_id']);
        $orderService->delete();
        $msg = app()->getLocale() == 'ar' ? 'تم الحذف بنجاح' :'successfully delete';
        return $this->ApiResponse('success',$msg);
    }
}
