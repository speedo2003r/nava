<?php

namespace App\Http\Controllers\Api\Tech;

use App\Entities\Income;
use App\Entities\Order;
use App\Entities\OrderBill;
use App\Entities\OrderGuarantee;
use App\Entities\OrderService;
use App\Enum\GuaranteeSolved;
use App\Enum\OrderStatus;
use App\Enum\UserType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\ServiceResource;
use App\Http\Resources\Orders\TechnicalGuaranteeOrderCollection;
use App\Http\Resources\Orders\TechnicalOrderDetailsResource;
use App\Http\Resources\Orders\TechnicalOrderCollection;
use App\Models\Room;
use App\Models\User;
use App\Notifications\Api\AddBillNotes;
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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
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
        $orders = $user->orders()->where('orders.status',OrderStatus::CREATED)->whereDoesntHave('refuseOrders',function ($query) use ($user){
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
            $orders = $user->ordersAsTech()->whereNotIn('orders.status', [OrderStatus::REJECTED,OrderStatus::FINISHED,OrderStatus::CREATED])->whereDoesntHave('refuseOrders')->orderBy('created_date','desc')->paginate(10);
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
                ->where('orders.status',OrderStatus::FINISHED)
                ->orderBy('created_date','desc')
                ->paginate(10);
        }else {
            $orders = $user->ordersAsTech()->where('orders.status', OrderStatus::FINISHED)->orderBy('created_date','desc')->paginate(10);
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
                ->where('solved', GuaranteeSolved::UNSOLVED)
                ->latest()
                ->paginate(10);
        }else {
            $orders = $user->GuaranteeOrders()->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))->where('status', 1)->where('solved', GuaranteeSolved::UNSOLVED)->paginate(10);
        }
        return $this->successResponse(TechnicalGuaranteeOrderCollection::make($orders));
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
        $user = auth()->user();
        if($order['delegate_id'] != null && $order['delegate_id'] != $user['id']){
            $msg = app()->getLocale() == 'ar' ? 'هذا الطلب غير تابع لك': 'This request does not belong to you';
            return $this->ApiResponse('fail', $msg);
        }
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
        $data = new Collection();
        $servicesData = Cache::get('order_service_'.$order['id'].'_'.$order->user['id']);
        if(!$servicesData){
            $servicesData = new Collection();
        }
        $vat_amount = 0;
        $total = 0;
        $service = $this->service->find($request['service_id']);
        $tax = ($service['price'] * settings('tax')) / 100;
        if(count($servicesData) > 0){
            foreach ($servicesData as $key => $d){
                if($d['id'] == $service['id']){
                    if ($request['counter'] == 'up') {
                        $count = $d['count'] + 1;
                        $data->push([
                            'id' => $service['id'],
                            'title' => $service['title'],
                            'type' => $service['type'],
                            'count' => $count,
                            'status' => 0,
                            'order_id' => $order['id'],
                            'category_id' => $request['category_id'],
                            'service_id' => $service['id'],
                            'price' => $service['price'],
                            'tax' => $tax,
                        ]);
                        $total += ($d['price'] + $d['tax']) * $count;
                        $vat_amount += $d['tax'] * $count;
                    }else{
                        if ($d['count'] == 1) {
                            $servicesData->pull($key);
                        }else{
                            $count = $d['count'] - 1;
                            $data->push([
                                'id' => $service['id'],
                                'title' => $service['title'],
                                'type' => $service['type'],
                                'count' => $count,
                                'status' => 0,
                                'order_id' => $order['id'],
                                'category_id' => $request['category_id'],
                                'service_id' => $service['id'],
                                'price' => $service['price'],
                                'tax' => $tax,
                            ]);
                            $total += ($d['price'] + $d['tax']) * $count;
                            $vat_amount += $d['tax'] * $count;
                        }
                    }
                }else{
                    $data->push([
                        'id' => $d['id'],
                        'title' => $d['title'],
                        'type' => $d['type'],
                        'count' => $d['count'],
                        'status' => 0,
                        'order_id' => $order['id'],
                        'category_id' => $request['category_id'],
                        'service_id' => $d['service_id'],
                        'price' => $d['price'],
                        'tax' => $d['tax'],
                    ]);
                    $total += ($d['price'] + $d['tax']) * $d['count'];
                    $vat_amount += $d['tax'] * $d['count'];
                }
            }
            if(!$servicesData->where('service_id',$request['service_id'])->first() && $request['counter'] == 'up'){
                $data->push([
                    'id' => $service['id'],
                    'title' => $service['title'],
                    'type' => $service['type'],
                    'count' => 1,
                    'status' => 0,
                    'order_id' => $order['id'],
                    'category_id' => $request['category_id'],
                    'service_id' => $service['id'],
                    'price' => $service['price'],
                    'tax' => $tax,
                ]);

                $total += ($service['price'] + $tax);
                $vat_amount += $tax;
            }
        }else{
            if($request['counter'] == 'up'){
                $data->push([
                    'id' => $service['id'],
                    'title' => $service['title'],
                    'type' => $service['type'],
                    'count' => 1,
                    'status' => 0,
                    'order_id' => $order['id'],
                    'category_id' => $request['category_id'],
                    'service_id' => $service['id'],
                    'price' => $service['price'],
                    'tax' => $tax,
                ]);
                $total += ($service['price'] + $tax);
                $vat_amount += $tax;
            }
        }
        Cache::put('order_service_'.$order['id'].'_'.$order->user['id'],$data,600);
        $msg = app()->getLocale() == 'ar' ? 'تم الاضافه بنجاح' : 'successfully add';
        return $this->ApiResponse('success',$msg,[
            'orderBill_id' => $order['id'] ?? 0,
            'tax' => $vat_amount ?? 0,
            'price' => $total ?? 0,
        ]);
    }

    public function addServiceNotify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orderBill_id' => 'sometimes|exists:orders,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['orderBill_id']);
        $servicesData = Cache::get('order_service_'.$order['id'].'_'.$order->user['id']);
        $tax = 0;
        $total = 0;
        if($servicesData && count($servicesData) > 0){
            $orderBill = OrderBill::create([
                'order_id'=>$order['id'],
                'type'=>'service',
                'status'=>0,
            ]);
            foreach ($servicesData as $data){
                $orderBill->orderServices()->create([
                    'title' => $data['title'],
                    'type' => $data['type'],
                    'count' => $data['count'],
                    'status' => 0,
                    'order_id' => $order['id'],
                    'category_id' => $data['category_id'],
                    'service_id' => $data['id'],
                    'price' => $data['price'],
                    'tax' => $data['tax'],
                ]);
                $tax += ($data['tax'] * $data['count']);
                $total += ($data['price'] * $data['count']);
            }
            $orderBill->refresh();
            $orderBill->update([
                'vat_amount' => $tax,
                'price' => $total,
            ]);
            $this->orderRepo->addBillStatusTimeLine($orderBill['id'],OrderStatus::NEWINVOICE);
            $order = $orderBill->order;
            $order->refresh();
            $user = $order->user;
            $user->notify(new AddBillNotes($order));
            $admins = User::where('user_type',UserType::ADMIN)->where('notify',1)->get();
            $job = (new \App\Jobs\TechAddBillNotes($admins,$order));
            dispatch($job);
            Cache::forget('order_service_'.$order['id'].'_'.$order->user['id']);
        }
        return $this->successResponse();
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
